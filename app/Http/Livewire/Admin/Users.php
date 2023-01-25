<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Hash;
use Livewire\Component;

class Users extends Component
{
    // sort properties
    public $orderBy = 'name';
    public $orderAsc = true;
    public $newUserName, $newUserEmail, $newUserPassword, $newUserAdmin;
    public $editUser = ['id' => null, 'name' => null];


    // validation rules
    public function rules()
    {
        return [
            'newUserName' => 'required|min:3',
            'newUserEmail' => 'required|min:3|unique:users,email,email',
            'newUserPassword' => 'required|min:8',
            'newUserAdmin' => 'required|boolean|in:0,1',
            'editUser.name' => 'required|min:3',
            'editUser.email' => 'required|min:3|email|unique:users,email,' . $this->editUser['id'],
            'editUser.admin' => 'required|boolean|in:0,1',
        ];
    }
    // validation attributes
    /*protected $validationAttributes = [
    'editUser.name' => 'user name',
];*/

    // custom validation messages
    protected $messages = [
        'newUserName.required' => 'Please enter a user name.',
        'newUserEmail.required' => 'Please enter a user email.',
        'newUserPassword.required' => 'Please enter a user password.',
        'newUser.min' => 'The new name must contains at least 3 characters and no more than 30 characters.',
        'newUser.max' => 'The new name must contains at least 3 characters and no more than 30 characters.',
        'newUser.unique' => 'This name already exists.',
        'editUser.name.required' => 'Please enter a user name.',
        'editUser.name.min' => 'This name is too short (must be between 3 and 30 characters).',
        'editUser.name.max' => 'This name is too long (must be between 3 and 30 characters)',
        'editUser.name.unique' => 'This name is already in use.',
    ];

    // reset $newUser and validation
    public function resetNewUser()
    {
        $this->reset('newUserName');
        $this->reset('newUserEmail');
        $this->reset('newUserPassword');
        $this->reset('newUserAdmin');
        $this->resetErrorBag();
    }

    // reset $editUser and validation
    public function resetEditUser()
    {
        $this->reset('editUser');
        $this->resetErrorBag();
    }

    // update an existing user
    public function updateUser(User $user)
    {
        $this->validateOnly('editUser.name');
        $this->validateOnly('editUser.email');
        $this->validateOnly('editUser.admin');
        $oldName = $user->name;
        $user->update([
            'name' => $this->editUser['name'],
            'email' => $this->editUser['email'],
            'admin' => $this->editUser['admin'],
        ]);
        $this->resetEditUser();
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The user <b><i>{$oldName}</i></b> has been updated to <b><i>{$user->name}</i></b>",
        ]);
    }

    // create a new user
    public function createUser()
    {
        // validate the new user
        $this->validateOnly('newUserName');
        $this->validateOnly('newUserEmail');
        $this->validateOnly('newUserPassword');
        $this->validateOnly('newUserAdmin');
        // create the user
        $user = User::create([
            'name' => $this->newUserName,
            'email' => $this->newUserEmail,
            'password' => Hash::make($this->newUserPassword),
            'admin' => $this->newUserAdmin,
        ]);
        // reset $newUser
        $this->resetNewUser();
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The user <b><i>{$user->name}</i></b> has been added",
        ]);
    }

    // delete a user
    public function deleteUser(User $user)
    {
        $user->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The user <b><i>{$user->name}</i></b> has been deleted",
        ]);
    }
    // listen to the delete-user event
    protected $listeners = [
        'delete-user' => 'deleteUser',
    ];

    // resort the users by the given column
    public function resort($column)
    {
        if ($this->orderBy === $column) {
            $this->orderAsc = !$this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $column;
    }

    // edit the value of $editUser (show inlined edit form)
    public function editExistingUser(User $user)
    {
        $this->editUser = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'admin' => $user->admin,
        ];
    }
    public function render()
    {
        $users = User::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->get();

        return view('livewire.admin.users', compact('users'))
            ->layout('layouts.warholshop', [
                'description' => 'Users',
                'title' => 'Users'
            ]);
    }
}
