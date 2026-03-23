<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UsersComponent extends Component
{
    public function render()
    {
        $users = User::all();

        return view('livewire.users-component', compact('users'))->layout('components.layouts.admin');
    }
}
