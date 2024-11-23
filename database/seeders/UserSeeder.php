<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create the Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'), // Hash the password for security
        ]);

        // Create the 'admin' role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin->assignRole($adminRole);  // Assign the role to the user

        // Create the Librarian User
        $librarian = User::create([
            'name' => 'Librarian',
            'email' => 'librarian@example.com',
            'password' => Hash::make('librarianpassword'), // Hash the password for security
        ]);

        // Create the 'librarian' role if it doesn't exist
        $librarianRole = Role::firstOrCreate(['name' => 'librarian']);
        $librarian->assignRole($librarianRole);  // Assign the role to the user
    }
}
