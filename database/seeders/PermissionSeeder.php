<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // Users Page
            'user-list',
            'user-create',
            'user-edit',
            'user-view',
            'user-delete',
            'user-viewAll',

            // Roles Page
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            // Permissions Page
            'permission-list',

            // Types Page
            'type-list',
            'type-create',
            'type-edit',
            'type-delete',

            // Colors Page
            'color-list',
            'color-create',
            'color-edit',
            'color-delete',

            // Pages Page
            'page-list',
            'page-create',
            'page-edit',
            'page-delete',

            // Sections Page
            'section-list',
            'section-create',
            'section-edit',
            'section-delete',

            // Collections Page
            'collection-list',
            'collection-create',
            'collection-edit',
            'collection-delete',

            // Entries Page
            'entry-list',
            'entry-create',
            'entry-edit',
            'entry-delete',
            

        ];
        
        $permissionsIds = [];
        foreach ($permissions as $permission) {
            $createdPermission = Permission::updateOrCreate(['name' => $permission]);
            $permissionsIds[] = $createdPermission->id;
        }

        $adminRole = Role::find(1);
        if($adminRole!=null){
            $adminRole->syncPermissions($permissionsIds);
        }
    }
}
