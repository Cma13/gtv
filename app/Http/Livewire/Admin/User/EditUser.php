<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{
    public $roles, $userId, $avatarRoute;

    protected $listeners = ['openEditModal'];

    public $editForm = [
        'open' => false,
        'name' => '',
        'email' => '',
        'password' => '',
        'role' => '',
    ];

    protected $rules = [
        'editForm.name' => 'required|string',
        'editForm.email' => 'required|confirmed|string|max:45|unique:users,email',
        'editForm.email_confirmation' => '',
        'editForm.password' => 'confirmed|string|min:8|max:500',
        'editForm.password_confirmation' => '',
        'editForm.role' => 'required|exists:roles,id',
    ];

    protected $validationAttributes = [
        'editForm.name' => 'nombre',
        'editForm.email' => 'email',
        'editForm.password' => 'contraseña',
        'editForm.role' => 'rol',
    ];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function openEditModal(User $user)
    {
        $this->reset(['editForm']);
        $this->reset(['avatarRoute']);

        $this->userId = $user->id;
        if ($user->profile_photo_path) {
            $this->avatarRoute = Storage::url($user->profile_photo_path);
        }
        $this->editForm['name'] = $user->name;
        $this->editForm['email'] = $user->email;
        $this->editForm['email_confirmation'] = $user->email;
        $this->editForm['role'] = $user->roles->first()->id;
        $this->editForm['open'] = true;
    }

    public function update(User $user)
    {
        $this->rules['editForm.email'] = 'required|confirmed|string|max:45|unique:users,email,' . $this->userId;

        $this->validate();

		$updateArray = [
            'name' => $this->editForm['name'],
            'email' => $this->editForm['email'],
        ];

		if ($this->editForm['password']) {
			$updateArray['password'] = Hash::make($this->editForm['password']);
		}

        $isUpdated = $user->update($updateArray);

        $role = Role::findById($this->editForm['role']);
        $user->syncRoles($role);

        if ($isUpdated) {
            Log::info('User with ID ' . auth()->user()->id . ' edited the following user ' . $user);
        }

        $this->editForm['open'] = false;
        $this->reset(['editForm']);
        $this->emitTo('admin.user.list-users', 'render');
        $this->emit('userUpdated');
    }

    public function render()
    {
        return view('livewire.admin.user.edit-user');
    }
}
