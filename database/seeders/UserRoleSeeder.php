<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(1); // Replace with a valid user ID
        if ($user) {
            $user->assignRole('admin');
            Log::info("Assigned 'admin' role to user {$user->id}");
        } else {
            Log::error('User not found with ID 1');
        }

        $user = User::find(2); // Replace with a valid user ID
        if ($user) {
            $user->assignRole('librarian');
            Log::info("Assigned 'librarian' role to user {$user->id}");
        } else {
            Log::error('User not found with ID 2');
        }
    }
}
