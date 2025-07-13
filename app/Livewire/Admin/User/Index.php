<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]

class Index extends Component
{
    use WithPagination;

    public $role;
    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $userToDelete;

    public function mount($role = 'admin')
    {
        $this->role = $role;
    }

    #[On('delete-user')]
    public function confirmDelete($id)
    {
        $this->userToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Yes, delete it!')
            ->option('denyButtonText', 'Cancel')
            ->option('id', $id)
            ->warning('Are you sure you want to delete this user?', ['Confirm Deletion']);
    }

    #[On('sweetalert:confirmed')]
    public function delete(array $payload)
    {
        $user = User::find($this->userToDelete);
        if ($user) {
            $user->delete();
            flash()->success('User deleted successfully!');
        } else {
            flash()->error('User not found.');
        }

        $this->userToDelete = null;
        $this->refreshUsers();
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        $this->userToDelete = null;
        flash()->info('User deletion cancelled.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('refresh-users')]
    public function refreshUsers()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::role($this->role)
        ->where(function ($query) {
            $query->where('username', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('livewire.admin.user.index', [
            'users' => $users,
            'role' => $this->role,
        ]);
    }
}
