<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'name' => 'Admin Utama',
                'username' => 'admin',
                'email' => 'admin@quizquest.com',
                'password' => Hash::make('admin123'), 
                'is_admin' => true, 
            ]);
        }
    }
}