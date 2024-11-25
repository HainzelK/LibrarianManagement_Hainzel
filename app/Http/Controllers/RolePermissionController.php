<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;

class RolePermissionController extends Controller
{
    public function createRolesAndPermissions()
    {
        // Create permissions
        $manageLibraryPermission = Permission::create([
            'name' => 'manage library inventory',
            'category' => 'Library Management',
        ]);

        $approveBookReservationPermission = Permission::create([
            'name' => 'approve book reservation',
            'category' => 'Library Management',
        ]);

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $librarianRole = Role::create(['name' => 'librarian']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($manageLibraryPermission);
        $adminRole->givePermissionTo($approveBookReservationPermission);

        $librarianRole->givePermissionTo($manageLibraryPermission);

        return response()->json('Roles and permissions created successfully!');
    }
}
