<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Check if the permission exists before creating
        $manageLibraryInventory = Permission::firstOrCreate([
            'name' => 'manage library inventory',
            'category' => 'Library Management',
        ]);

        $approveBookReservation = Permission::firstOrCreate([
            'name' => 'approve book reservation',
            'category' => 'Library Management',
        ]);

        $borrowPhysicalBook = Permission::firstOrCreate([
            'name' => 'borrow physical book',
            'category' => 'Book Management',
        ]);

        $viewEbook = Permission::firstOrCreate([
            'name' => 'view ebook',
            'category' => 'Book Management',
        ]);

        $requestEbookCode = Permission::firstOrCreate([
            'name' => 'request ebook code',
            'category' => 'Book Management',
        ]);

        $requestJournalAccess = Permission::firstOrCreate([
            'name' => 'request journal access',
            'category' => 'Journal Management',
        ]);

        $approveJournalAccess = Permission::firstOrCreate([
            'name' => 'approve journal access',
            'category' => 'Journal Management',
        ]);

        $requestNewspaperAccess = Permission::firstOrCreate([
            'name' => 'request newspaper access',
            'category' => 'Newspaper Management',
        ]);

        $approveNewspaperAccess = Permission::firstOrCreate([
            'name' => 'approve newspaper access',
            'category' => 'Newspaper Management',
        ]);

        $requestCdDvdAccess = Permission::firstOrCreate([
            'name' => 'request cd/dvd access',
            'category' => 'Cd/Dvd Management',
        ]);

        $approveCdDvdAccess = Permission::firstOrCreate([
            'name' => 'approve cd/dvd access',
            'category' => 'Cd/Dvd Management',
        ]);

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $librarianRole = Role::firstOrCreate(['name' => 'librarian']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);  // Optional, for managing students' permissions

        // Assign permissions to roles
        $adminRole->givePermissionTo([
            $manageLibraryInventory,
            $approveBookReservation,
            $borrowPhysicalBook,
            $viewEbook,
            $requestEbookCode,
            $requestJournalAccess,
            $approveJournalAccess,
            $requestNewspaperAccess,
            $approveNewspaperAccess,
            $requestCdDvdAccess,
            $approveCdDvdAccess,
        ]);

        $librarianRole->givePermissionTo([
            $manageLibraryInventory,
            $borrowPhysicalBook,
            $viewEbook,
            $requestEbookCode,
            $requestJournalAccess,
            $approveJournalAccess,
            $requestNewspaperAccess,
            $approveNewspaperAccess,
            $requestCdDvdAccess,
            $approveCdDvdAccess,
        ]);

        $studentRole->givePermissionTo([
            $requestEbookCode,
            $requestJournalAccess,
            $requestNewspaperAccess,
            $requestCdDvdAccess,
        ]);
    }
}
