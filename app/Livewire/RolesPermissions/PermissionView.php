<?php

namespace App\Livewire\RolesPermissions;

use App\Http\Resources\PermissionResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionView extends Component
{
    use AuthorizesRequests;

    public $roles;
    public array $rolesBadgeObj = [];

    public function mount()
    {
        $this->authorize('permission-list');
        $this->roles = Role::all();

        $this->rolesBadgeObj = [];
        foreach ($this->roles as $role) {
            $badgeClass = match ($role->name) {
                'Super Admin' => 'danger',
                'Procurement Manager' => 'success',
                default => 'warning',
            };
            $this->rolesBadgeObj[$role->name] = "<span class='badge bg-label-$badgeClass m-1'>$role->name</span>";
        }
    }

    public function render()
    {
        $data = [];
        $data['permissions'] = PermissionResource::collection(Permission::all());

        return view('livewire.roles-permissions.permission-view', $data);
    }
}
