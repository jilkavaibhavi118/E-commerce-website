<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            // Clear old cached roles/permissions
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            // Create roles
            Role::firstOrCreate(['name' => 'Admin']);
            Role::firstOrCreate(['name' => 'Manager']);
            Role::firstOrCreate(['name' => 'Customer']);

    }
}
