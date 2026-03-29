<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UsersComponent extends Component
{
    public function render()
    {
        $users = User::withCount('products')
                     ->withSum('orders', 'quantity')
                     ->get();

        return view('livewire.users-component', compact('users'))->layout('components.layouts.admin');
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            session()->flash('error', 'User not found.');
            return;
        }

        $user->delete();

        session()->flash('message', 'User deleted successfully.');
    }
}
