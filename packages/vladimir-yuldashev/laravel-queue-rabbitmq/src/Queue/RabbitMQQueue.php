<?php

/** @noinspection PhpRedundantCatchClauseInspection */

namespace VladimirYuldashev\LaravelQueueRabbitMQ\Queue;

use ErrorException;
use Exception;
use Illuminate\Contracts\Queue\Queue as QueueContract;
use Illuminate\Queue\Queue;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JsonException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Exception\AMQPChannelClosedException;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use Throwable;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;

class RabbitMQQueue extends Queue implements QueueContract
{
    /**
     * The RabbitMQ connection instance.
     *
     * @var AbstractConnection
     */
    protected $connection;

    /**
     * The RabbitMQ channel instance.
     *
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * The name of the default queue.
     *
     * @var string
     */
    protected $default;

    /**
     * List of already declared exchanges.
     *
     * @var array
     */
    protected $exchanges = [];

    /**
     * List of already declared queues.
     *
     * @var array
     */
    protected $queues = [];

    /**
     * List of already bound queues to exchanges.
     *
     * @var array
     */
    protected $boundQueues = [];

    /**
     * Current job being processed.
     *
     * @var RabbitMQJob
     */
    protected $currentJob;

    /**
     * @var array
     */
    protected $options;

    /**
     * RabbitMQQueue constructor.
     *
     * @param  AbstractConnection  $connection
     * @param  string  $default
     * @param  bool  $dispatchAfterCommit
     * @param  array  $options
     */
    public function __construct(
        AbstractConnection $connection,
        string $default,
        bool $dispatchAfterCommit = false,
        array $options = []
    ) {
        $this->connection = $connection;
        $this->channel = $connection->channel();
        $this->default = $default;
        $this->options = $options;
        $this->dispatchAfterCommit = $dispatchAfterCommit;
    }

    /**
     * {@inheritdoc}
     *
     * @throws AMQPProtocolChannelException
     */
    public function size($queue = null): int
    {
        $queue = $this->getQueue($queue);

        if (! $this->isQueueExists($queue)) {
            return 0;
        }

        // create a temporary channel, so the main channel will not be closed on exception
        $channel = $this->connection->channel();
        [, $size] = $channel->queue_declare($queue, true);
        $channel->close();

        return $size;
    }

    /**
     * {@inheritdoc}
     *
     * @throws AMQPProtocolChannelException
     */
    public function push($job, $data = '', $queue = null)
    {
        return $this->enqueueUsing(
            $job,
            $this->createPayload($job, $this->getQueue($queue), $data),
            $queue,
            null,
            function ($payload, $queue) {
                return $this->pushRaw($payload, $queue);
            }
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws AMQPProtocolChannelException
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
        [$destination, $exchange, $exchangeType, $attempts] = $this->publishProperties($queue, $options);

        $this->declareDestination($destination, $exchange, $exchangeType);

        [$message, $correlationId] = $this->createMessage($payload, $attempts);

        $this->channel->basic_publish($message, $exchange, $destination, true, false);

        return $correlationId;
    }

    /**
     * {@inheritdoc}
     *
     * @throws AMQPProtocolChannelException
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        return $this->enqueueUsing(
            $job,
            $this->createPayload($job, $this->getQueue($queue), $data),
            $queue,
            $delay,
            function ($payload, $queue, $delay) {
                return $this->laterRaw($delay, $payload, $queue);
            }
        );
    }

    /**
     * @param $delay
     * @param $payload
     * @param  null  $queue
     * @param  int  $attempts
     * @return mixed
     *
     * @throws AMQPProtocolChannelException
     */
    public function laterRaw($delay, $payload, $queue = null, $attempts = 0)
    {
        $ttl = $this->secondsUntil($delay) * 1000;

        // When no ttl just publish a new message to the exchange or queue
        if ($ttl <= 0) {
            return $this->pushRaw($payload, $queue, ['delay' => $delay, 'attempts' => $attempts]);
        }

        $destination = $this->getQueue($queue).'.delay.'.$ttl;

        $this->declareQueue($destination, true, false, $this->getDelayQueueArguments($this->getQueue($queue), $ttl));

        [$message, $correlationId] = $this->createMessage($payload, $attempts);

        // Publish directly on the delayQueue, no need to publish trough an exchange.
        $this->channel->basic_publish($message, null, $destination, true, false);

        return $correlationId;
    }

    /**
     * {@inheritdoc}
     *
     * @throws AMQPProtocolChannelException
     */
    public function bulk($jobs, $data = '', $queue = null): void
    {
        foreach ((array) $jobs as $job) {
            $this->bulkRaw($this->createPayload($job, $queue, $data), $queue, ['job' => $job]);
        }

        $this->channel->publish_batch();
    }

    /**
     * @param  string  $payload
     * @param  null  $queue
     * @param  array  $options
     * @return mixed
     *
     * @throws AMQPProtocolChannelException
     */
    public function bulkRaw(string $payload, $queue = null, array $options = [])
    {
        [$destination, $exchange, $exchangeType, $attempts] = $this->publishProperties($queue, $options);

        $this->declareDestination($destination, $exchange, $exchangeType);

        [$message, $correlationId] = $this->createMessage($payload, $attempts);

        $this->channel->batch_basic_publish($message, $exchange, $destination);

        return $correlationId;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Throwable
     */
    public function pop($queue = null)
    {
        try {
            $queue = $this->getQueue($queue);

            $job = $this->getJobClass();

            /** @var AMQPMessage|null $message */
            if ($message = $this->channel->basic_get($queue)) {
                return $this->currentJob = new $job(
                    $this->container,
                    $this,
                    $message,
                    $this->connectionName,
                    $queue
                );
            }
        } catch (AMQPProtocolChannelException $exception) {
            // If there is not exchange or queue AMQP will throw exception with code 404
            // We need to catch it and return null
            if ($exception->amqp_reply_code === 404) {
                // Because of the channel exception the channel was closed and removed.
                // We have to open a new channel. Because else the worker(s) are stuck in a loop, without processing.
                $this->channel = $this->connection->channel();

                return null;
            }

            throw $exception;
        } catch (AMQPChannelClosedException|AMQPConnectionClosedException $exception) {
            // Queue::pop used by worker to receive new job
            // Thrown exception is checked by Illuminate\Database\DetectsLostConnections::causedByLostConnection
            // Is has to contain one of the several phrases in exception message in order to restart worker
            // Otherwise worker continues to work with broken connection
            throw new AMQPRuntimeException(
                'Lost connection: '.$exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return null;
    }

    /**
     * @return AbstractConnection
     */
    public function getConnection(): AbstractConnection
    {
        return $this->connection;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * Job class to use.
     *
     * @return string
     *
     * @throws Throwable
     */
    public function getJobClass(): string
    {
        $job = Arr::get($this->options, 'job', RabbitMQJob::class);

        throw_if(
            ! is_a($job, RabbitMQJob::class, true),
            Exception::class,
            sprintf('Class %s must extend: %s', $job, RabbitMQJob::class)
        );

        return $job;
    }

    /**
     * Gets a queue/destination, by default the queue option set on the connection.
     *
     * @param  null  $queue
     * @return string
     */
    public function getQueue($queue = null): string
    {
        return $queue ?: $this->default;
    }

    /**
     * Checks if the given exchange already present/defined in RabbitMQ.
     * Returns false when when the exchange is missing.
     *
     * @param  string  $exchange
     * @return bool
     *
     * @throws AMQPProtocolChannelException
     */
    public function isExchangeExists(string $exchange): bool
    {
        if ($this->isExchangeDeclared($exchange)) {
            return true;
        }

        try {
            // create a temporary channel, so the main channel will not be closed on exception
            $channel = $this->connection->channel();
            $channel->exchange_declare($exchange, '', true);
            $channel->close();

            $this->exchanges[] = $exchange;

            return true;
        } catch (AMQPProtocolChannelException $exception) {
            if ($exception->amqp_reply_code === 404) {
                return false;
            }

            throw $exception;
        }
    }

    /**
     * Declare a exchange in rabbitMQ, when not already declared.
     *
     * @param  string  $name
     * @param  string  $type
     * @param  bool  $durable
     * @param  bool  $autoDelete
     * @param  array  $arguments
     * @return void
     */
    public function declareExchange(
        string $name,
        string $type = AMQPExchangeType::DIRECT,
        bool $durable = true,
        bool $autoDelete = false,
        array $arguments = []
    ): void {
        if ($this->isExchangeDeclared($name)) {
            return;
        }

        $this->channel->exchange_declare(
            $name,
            $type,
            false,
            $durable,
            $autoDelete,
            false,
            true,
            new AMQPTable($arguments)
        );
    }

    /**
     * Delete a exchange from rabbitMQ, only when present in RabbitMQ.
     *
     * @param  string  $name
     * @param  bool  $unused
     * @return void
     *
     * @throws AMQPProtocolChannelException
     */
    public function deleteExchange(string $name, bool $unused = false): void
    {
        if (! $this->isExchangeExists($name)) {
            return;
        }

        $idx = array_search($name, $this->exchanges);
        unset($this->exchanges[$idx]);

        $this->channel->exchange_delete(
            $name,
            $unused
        );
    }

    /**
     * Checks if the given queue already present/defined in RabbitMQ.
     * Returns false when when the queue is missing.
     *
     * @param  string|null  $name
     * @return bool
     *
     * @throws AMQPProtocolChannelException
     */
    public function isQueueExists(string $name = null): bool
    {
        try {
            // create a temporary channel, so the main channel will not be closed on exception
            $channel = $this->connection->channel();
            $channel->queue_declare($this->getQueue($name), true);
            $channel->close();

            return true;
        } catch (AMQPProtocolChannelException $exception) {
            if ($exception->amqp_reply_code === 404) {
                return false;
            }

            throw $exception;
        }
    }

    /**
     * Declare a queue in rabbitMQ, when not already declared.
     *
     * @param  string  $name
     * @param  bool  $durable
     * @param  bool  $autoDelete
     * @param  array  $arguments
     * @return void
     */
    public function declareQueue(
        string $name,
        bool $durable = true,
        bool $autoDelete = false,
        array $arguments = []
    ): void {
        if ($this->isQueueDeclared($name)) {
            return;
        }

        $this->channel->queue_declare(
            $name,
            false,
            $durable,
            false,
            $autoDelete,
            false,
            new AMQPTable($arguments)
        );
    }

    /**
     * Delete a queue from rabbitMQ, only when present in RabbitMQ.
     *
     * @param  string  $name
     * @param  bool  $if_unused
     * @param  bool  $if_empty
     * @return void
     *
     * @throws AMQPProtocolChannelException
     */
    public function deleteQueue(string $name, bool $if_unused = false, bool $if_empty = false): void
    {
        if (! $this->isQueueExists($name)) {
            return;
        }

        $this->channel->queue_delete($name, $if_unused, $if_empty);
    }

    /**
     * Bind a queue to an exchange.
     *
     * @param  string  $queue
     * @param  string  $exchange
     * @param  string  $routingKey
     * @return void
     */
    public function bindQueue(string $queue, string $exchange, string $routingKey = ''): void
    {
        if (in_array(
            implode('', compact('queue', 'exchange', 'routingKey')),
            $this->boundQueues,
            true
        )) {
            return;
        }

        $this->channel->queue_bind($queue, $exchange, $routingKey);
    }

    /**
     * Purge the queue of messages.
     *
     * @param  string|null  $queue
     * @return void
     */
    public function purge(string $queue = null): void
    {
        // create a temporary channel, so the main channel will not be closed on exception
        $channel = $this->connection->channel();
        $channel->queue_purge($this->getQueue($queue));
        $channel->close();
    }

    /**
     * Acknowledge the message.
     *
     * @param  RabbitMQJob  $job
     * @return void
     */
    public function ack(RabbitMQJob $job): void
    {
        $this->channel->basic_ack($job->getRabbitMQMessage()->getDeliveryTag());
    }

    /**
     * Reject the message.
     *
     * @param  RabbitMQJob  $job
     * @param  bool  $requeue
     * @return void
     */
    public function reject(RabbitMQJob $job, bool $requeue = false): void
    {
        $this->channel->basic_reject($job->getRabbitMQMessage()->getDeliveryTag(), $requeue);
    }

    /**
     * Create a AMQP message.
     *
     * @param $payload
     * @param  int  $attempts
     * @return array
     *
     * @throws JsonException
     */
    protected function createMessage($payload, int $attempts = 0): array
    {
        $properties = [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        ];

        $currentPayload = json_decode($payload, true, 512);
        if ($correlationId = $currentPayload['id'] ?? null) {
            $properties['correlation_id'] = $correlationId;
        }

        if ($this->isPrioritizeDelayed()) {
            $properties['priority'] = $attempts;
        }

        if (isset($currentPayload['data']['command'])) {
            $commandData = unserialize($currentPayload['data']['command']);
            if (property_exists($commandData, 'priority')) {
                $properties['priority'] = $commandData->priority;
            }
        }

        $message = new AMQPMessage($payload, $properties);

        $message->set('application_headers', new AMQPTable([
            'laravel' => [
                'attempts' => $attempts,
            ],
        ]));

        return [
            $message,
            $correlationId,
        ];
    }

    /**
     * Create a payload array from the given job and data.
     *
     * @param  string|object  $job
     * @param  string  $queue
     * @param  mixed  $data
     * @return array
     */
    protected function createPayloadArray($job, $queue, $data = ''): array
    {
        return array_merge(parent::createPayloadArray($job, $queue, $data), [
            'id' => $this->getRandomId(),
        ]);
    }

    /**
     * Get a random ID string.
     *
     * @return string
     */
    protected function getRandomId(): string
    {
        return Str::uuid();
    }

    /**
     * Close the connection to RabbitMQ.
     *
     * @return void
     *
     * @throws Exception
     */
    public function close(): void
    {
        if ($this->currentJob && ! $this->currentJob->isDeletedOrReleased()) {
            $this->reject($this->currentJob, true);
        }

        try {
            $this->connection->close();
        } catch (ErrorException $exception) {
            // Ignore the exception
        }
    }

    /**
     * Get the Queue arguments.
     *
     * @param  string  $destination
     * @return array
     */
    protected function getQueueArguments(string $destination): array
    {
        $arguments = [];

        // Messages without a priority property are treated as if their priority were 0.
        // Messages with a priority which is higher than the queue's maximum, are treated as if they were
        // published with the maximum priority.
        // Quorum queues does not support priority.
        if ($this->isPrioritizeDelayed() && ! $this->isQuorum()) {
            $arguments['x-max-priority'] = $this->getQueueMaxPriority();
        }

        if ($this->isRerouteFailed()) {
            $arguments['x-dead-letter-exchange'] = $this->getFailedExchange() ?? '';
            $arguments['x-dead-letter-routing-key'] = $this->getFailedRoutingKey($destination);
        }

        if ($this->isQuorum()) {
            $arguments['x-queue-type'] = 'quorum';
        }

        return $arguments;
    }

    /**
     * Get the Delay queue arguments.
     *
     * @param  string  $destination
     * @param  int  $ttl
     * @return array
     */
    protected function getDelayQueueArguments(string $destination, int $ttl): array
    {
        return [
            'x-dead-letter-exchange' => $this->getExchange() ?? '',
            'x-dead-letter-routing-key' => $this->getRoutingKey($destination),
            'x-message-ttl' => $ttl,
            'x-expires' => $ttl * 2,
        ];
    }

    /**
     * Returns &true;, if delayed messages should be prioritized.
     *
     * @return bool
     */
    protected function isPrioritizeDelayed(): bool
    {
        return (bool) (Arr::get($this->options, 'prioritize_delayed') ?: false);
    }

    /**
     * Returns a integer with a default of '2' for when using prioritization on delayed messages.
     * If priority queues are desired, we recommend using between 1 and 10.
     * Using more priority layers, will consume more CPU resources and would affect runtimes.
     *
     * @see https://www.rabbitmq.com/priority.html
     *
     * @return int
     */
    protected function getQueueMaxPriority(): int
    {
        return (int) (Arr::get($this->options, 'queue_max_priority') ?: 2);
    }

    /**
     * Get the exchange name, or &null; as default value.
     *
     * @param  string|null  $exchange
     * @return string|null
     */
    protected function getExchange(string $exchange = null): ?string
    {
        return $exchange ?: Arr::get($this->options, 'exchange') ?: null;
    }

    /**
     * Get the routing-key for when you use exchanges
     * The default routing-key is the given destination.
     *
     * @param  string  $destination
     * @return string
     */
    protected function getRoutingKey(string $destination): string
    {
        return ltrim(sprintf(Arr::get($this->options, 'exchange_routing_key') ?: '%s', $destination), '.');
    }

    /**
     * Get the exchangeType, or AMQPExchangeType::DIRECT as default.
     *
     * @param  string|null  $type
     * @return string
     */
    protected function getExchangeType(?string $type = null): string
    {
        return @constant(AMQPExchangeType::class.'::'.Str::upper($type ?: Arr::get(
            $this->options,
            'exchange_type'
        ) ?: 'direct')) ?: AMQPExchangeType::DIRECT;
    }

    /**
     * Returns &true;, if failed messages should be rerouted.
     *
     * @return bool
     */
    protected function isRerouteFailed(): bool
    {
        return (bool) (Arr::get($this->options, 'reroute_failed') ?: false);
    }

    /**
     * Returns &true;, if declared queue must be quorum queue.
     *
     * @return bool
     */
    protected function isQuorum(): bool
    {
        return (bool) (Arr::get($this->options, 'quorum') ?: false);
    }

    /**
     * Get the exchange for failed messages.
     *
     * @param  string|null  $exchange
     * @return string|null
     */
    protected function getFailedExchange(string $exchange = null): ?string
    {
        return $exchange ?: Arr::get($this->options, 'failed_exchange') ?: null;
    }

    /**
     * Get the routing-key for failed messages
     * The default routing-key is the given destination substituted by '.failed'.
     *
     * @param  string  $destination
     * @return string
     */
    protected function getFailedRoutingKey(string $destination): string
    {
        return ltrim(sprintf(Arr::get($this->options, 'failed_routing_key') ?: '%s.failed', $destination), '.');
    }

    /**
     * Checks if the exchange was already declared.
     *
     * @param  string  $name
     * @return bool
     */
    protected function isExchangeDeclared(string $name): bool
    {
        return in_array($name, $this->exchanges, true);
    }

    /**
     * Checks if the queue was already declared.
     *
     * @param  string  $name
     * @return bool
     */
    protected function isQueueDeclared(string $name): bool
    {
        return in_array($name, $this->queues, true);
    }

    /**
     * Declare the destination when necessary.
     *
     * @param  string  $destination
     * @param  string|null  $exchange
     * @param  string|null  $exchangeType
     * @return void
     *
     * @throws AMQPProtocolChannelException
     */
    protected function declareDestination(
        string $destination,
        ?string $exchange = null,
        string $exchangeType = AMQPExchangeType::DIRECT
    ): void {
        // When a exchange is provided and no exchange is present in RabbitMQ, create an exchange.
        if ($exchange && ! $this->isExchangeExists($exchange)) {
            $this->declareExchange($exchange, $exchangeType);
        }

        // When a exchange is provided, just return.
        if ($exchange) {
            return;
        }

        // When the queue already exists, just return.
        if ($this->isQueueExists($destination)) {
            return;
        }

        // Create a queue for amq.direct publishing.
        $this->declareQueue($destination, true, false, $this->getQueueArguments($destination));
    }

    /**
     * Determine all publish properties.
     *
     * @param $queue
     * @param  array  $options
     * @return array
     */
    protected function publishProperties($queue, array $options = []): array
    {
        $queue = $this->getQueue($queue);
        $attempts = Arr::get($options, 'attempts') ?: 0;

        $destination = $this->getRoutingKey($queue);
        $exchange = $this->getExchange(Arr::get($options, 'exchange'));
        $exchangeType = $this->getExchangeType(Arr::get($options, 'exchange_type'));

        return [$destination, $exchange, $exchangeType, $attempts];
    }
}
