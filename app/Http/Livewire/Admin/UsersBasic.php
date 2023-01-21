<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class UsersBasic extends Component
{
    public function render()
    {
        return view('livewire.admin.users-basic')
            ->layout('layouts.warholshop', [
                'description' => 'Users',
                'title' => 'Users'
            ]);
    }
}
