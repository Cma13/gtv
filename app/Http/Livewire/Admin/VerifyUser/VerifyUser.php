<?php

namespace App\Http\Livewire\Admin\VerifyUser;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class VerifyUser extends Component
{
	use WithPagination;

	public $listeners = ['verify'];

	public $search;
	public $searchColumn = 'id';

	public $sortField = 'id';
	public $sortDirection = 'desc';

	protected $queryString = ['search'];

	public $detailsModal = [
		'open' => false,
		'avatar' => null,
		'id' => null,
		'name' => '',
		'email' => '',
		'password' => '',
		'emailVerifiedAt' => '',
		'createdAt' => '',
		'updatedAt' => '',
	];

	public function show(User $user)
	{
		$this->reset(['detailsModal']);

		$this->detailsModal['open'] = true;
		if ($user->profile_photo_path) {
			$this->detailsModal['avatar'] = Storage::url($user->profile_photo_path);
		}
		$this->detailsModal['id'] = $user->id;
		$this->detailsModal['name'] = $user->name;
		$this->detailsModal['email'] = $user->email;
		$this->detailsModal['password'] = $user->password;
		$this->detailsModal['emailVerifiedAt'] = $user->email_verified_at;
		$this->detailsModal['createdAt'] = $user->created_at;
		$this->detailsModal['updatedAt'] = $user->updated_at;
	}

	public function verify(User $user)
	{
		$user->syncRoles(['Alumno']);
		Log::alert('User with ID ' . auth()->user()->id . ' verified a student ' . $user);
	}

	public function sort($field)
	{
		if ($this->sortField === $field && $this->sortDirection !== 'desc') {
			$this->sortDirection = 'desc';
		} else {
			$this->sortDirection = 'asc';
		}

		$this->sortField = $field;
	}

	public function resetFilters()
	{
		$this->reset(['search', 'sortField', 'sortDirection']);
		$this->resetPage();
	}

	public function updatingSearch()
	{
		$this->resetPage();
	}

	public function render()
	{
		$users = User::query()->role('Usuario sin verificar')
			->where('email', '<>', auth()->user()->email)
			->where($this->searchColumn, 'like', '%'. $this->search .'%')
			->orderBy($this->sortField, $this->sortDirection)
			->paginate(10);

		return view('livewire.admin.verify-user.verify-user', compact('users'));
	}
}
