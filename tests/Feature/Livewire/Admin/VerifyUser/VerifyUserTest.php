<?php

namespace Tests\Feature\Livewire\Admin\VerifyUser;

use App\Http\Livewire\Admin\VerifyUser\VerifyUser;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class VerifyUserTest extends TestCase
{
	use RefreshDatabase;

	protected $seed = PermissionsSeeder::class;

	/** @test */
	public function TestUnverifiedUserShowsInView()
	{
		$teacher = $this->createTeacher();
		$user = $this->createUnverifiedUser();

		$this->actingAs($teacher);

		Livewire::test(VerifyUser::class)
			->assertSee($user->name)
			->assertSee($user->email);
	}

	/** @test */
	public function TestVerifiedUserDoesNotShowInView()
	{
		$teacher = $this->createTeacher();
		$user = $this->createStudent();

		$this->actingAs($teacher);

		Livewire::test(VerifyUser::class)
			->assertDontSee($user->name)
			->assertDontSee($user->email);
	}

	/** @test */
	public function TestOnlyAdminsAndTeachersCanVerify()
	{
		$admin = $this->createAdmin();
		$teacher = $this->createTeacher();
		$student = $this->createStudent();
		$unverifiedUser = $this->createUnverifiedUser();

		$response = $this->actingAs($unverifiedUser)->get(route('verify-users.index'));
		$response->assertStatus(403);

		$response = $this->actingAs($student)->get(route('verify-users.index'));
		$response->assertStatus(403);

		$response = $this->actingAs($teacher)->get(route('verify-users.index'));
		$response->assertStatus(200);

		$response = $this->actingAs($admin)->get(route('verify-users.index'));
		$response->assertStatus(200);
	}

	/** @test */
	public function TestItVerifiesUser()
	{
		$teacher = $this->createTeacher();
		$user = $this->createUnverifiedUser();

		$this->actingAs($teacher);

		$this->assertFalse($user->hasRole('Alumno'));
		$this->assertTrue($user->hasRole('Usuario sin verificar'));

		Livewire::test(VerifyUser::class)
			->emit('verify', $user->id);

		$user->refresh();
		$this->assertTrue($user->hasRole('Alumno'));
		$this->assertFalse($user->hasRole('Usuario sin verificar'));
	}
}
