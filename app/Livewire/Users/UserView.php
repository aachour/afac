<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class UserView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->authorize('user-delete');

        if ($id == 1) {
            return to_route('users')->with('error', 'You cannot delete the user with ID 1.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return to_route('users')->with('success', 'User has been deleted successfully!');
    }

    public function render()
    {
        $data = [];

        $users = User::all();
        $data['users'] = $users;

        return view('livewire.users.user-view', $data);
    }
}
