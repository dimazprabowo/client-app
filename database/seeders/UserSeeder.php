<?php

namespace Database\Seeders;

use App\Enums\UserApprovalStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $seedUsers = [
            [
                'email' => 'superadmin@app.com',
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '021-1234566',
                'position' => 'Super Administrator',
                'role' => 'super admin',
            ],
            [
                'email' => 'admin@app.com',
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'phone' => '021-1234567',
                'position' => 'System Administrator',
                'role' => 'admin',
            ],
            [
                'email' => 'user@app.com',
                'name' => 'Sample User',
                'password' => Hash::make('password'),
                'phone' => '021-1234568',
                'position' => 'Staff',
                'role' => 'user',
            ],
        ];

        foreach ($seedUsers as $data) {
            $role = $data['role'];
            unset($data['role']);

            $data['is_active'] = true;
            $data['approval_status'] = UserApprovalStatus::Approved;
            $data['email_verified_at'] = now();

            $user = User::firstOrCreate(['email' => $data['email']], $data);
            if (! $user->hasRole($role)) {
                $user->assignRole($role);
            }
        }
    }
}
