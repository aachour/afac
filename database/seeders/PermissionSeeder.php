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

            // Countries Page
            'country-list',
            'country-edit',

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
            'page-view',
            
            // Sections Page
            'section-list',
            'section-create',
            'section-edit',
            'section-delete',
            'section-view',
            
            // Collections Page
            'collection-list',
            'collection-create',
            'collection-edit',
            'collection-delete',
            'collection-view',

            // Entries Page
            'entry-list',
            'entry-create',
            'entry-edit',
            'entry-delete',
            'entry-view',
            
            // Events Categories
            'eventCategory-list',
            'eventCategory-create',
            'eventCategory-edit',
            'eventCategory-delete',
            'eventCategory-view',

            // Events Page
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'event-view',

            // Programs Page
            'program-list',
            'program-create',
            'program-edit',
            'program-delete',
            'program-view',

            // Projects Categories
            'projectCategory-list',
            'projectCategory-create',
            'projectCategory-edit',
            'projectCategory-delete',
            'projectCategory-view',
            
            // Projects Page
            'project-list',
            'project-create',
            'project-edit',
            'project-delete',
            'project-view',

            // Projects Categories
            'granteeCategory-list',
            'granteeCategory-create',
            'granteeCategory-edit',
            'granteeCategory-delete',
            'granteeCategory-view',

            // Grantees Page
            'grantee-list',
            'grantee-create',
            'grantee-edit',
            'grantee-delete',
            'grantee-view',

            // Jurors Page
            'jury-list',
            'jury-create',
            'jury-edit',
            'jury-delete',
            'jury-view',

            // Resources Page
            'resource-list',
            'resource-create',
            'resource-edit',
            'resource-delete',
            'resource-view',

            // News Categories
            'newsCategory-list',
            'newsCategory-create',
            'newsCategory-edit',
            'newsCategory-delete',
            'newsCategory-view',

            // News Page
            'news-list',
            'news-create',
            'news-edit',
            'news-delete',
            'news-view',

            // Projects Categories
            'externalCategory-list',
            'externalCategory-create',
            'externalCategory-edit',
            'externalCategory-delete',
            'externalCategory-view',

            // externals Page
            'external-list',
            'external-create',
            'external-edit',
            'external-delete',
            'external-view',

            // team member Page
            'team-list',
            'team-create',
            'team-edit',
            'team-delete',
            'team-view',

            // board member Page
            'board-list',
            'board-create',
            'board-edit',
            'board-delete',
            'board-view',

            // Files Library
            'file-list',
            'file-create',
            'file-edit',
            'file-delete',

            // Logo
            'logo-list',
            'logo-edit',

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
