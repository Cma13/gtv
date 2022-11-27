<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class UserProfile extends Component
{
    public $listeners = ['render'];

    public function countVerifyElements()
    {
        return countVerifyElementsHelper();
    }

    public function render()
    {
        return view('livewire.admin.user-profile');
    }
}
