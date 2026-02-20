<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $ownerRole = Role::query()->firstOrCreate(['name' => 'owner']);
        $adminRole = Role::query()->firstOrCreate(['name' => 'admin']);
        $studentRole = Role::query()->firstOrCreate(['name' => 'student']);

        User::query()->updateOrCreate(
            ['email' => 'admin@boarding.test'],
            [
                'name' => 'System Admin',
                'password' => 'password',
                'role_id' => $adminRole->id,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'owner@boarding.test'],
            [
                'name' => 'Sample Owner',
                'password' => 'password',
                'role_id' => $ownerRole->id,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'student@boarding.test'],
            [
                'name' => 'Sample Student',
                'password' => 'password',
                'role_id' => $studentRole->id,
            ]
        );
    }
}
