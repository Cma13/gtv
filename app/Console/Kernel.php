<?php

namespace App\Console;

use App\Models\Photography;
use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            PointOfInterest::where('deleted_at', '<', Carbon::now()->subDays(7))->forceDelete();
            Place::where('deleted_at', '<', Carbon::now()->subDays(7))->forceDelete();
            Video::where('deleted_at', '<', Carbon::now()->subDays(7))->forceDelete();
            Photography::where('deleted_at', '<', Carbon::now()->subDays(7))->forceDelete();
        })->weekly();

		$schedule->call(function() {
			User::Unverified()->where('created_at', '<', now()->subDays(30))->forceDelete();
		})->daily();
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
