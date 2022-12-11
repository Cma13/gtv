<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
	use RefreshDatabase;

	public function test_deletes_unverified_users_older_than_30_days()
	{
		$user = $this->createUnverifiedUser();
		$this->assertDatabaseHas('users', [
			'id' => $user->id,
		]);
		$this->travelto(now()->addDays(31)->startOfDay());
		$this->artisan('schedule:run');
		$this->assertDatabaseMissing('users', [
			'id' => $user->id,
		]);
	}
}
