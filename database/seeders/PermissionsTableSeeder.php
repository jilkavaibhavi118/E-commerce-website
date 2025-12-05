<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    public array $permissions = [
        //
        'roles.view', 'roles.create', 'roles.edit', 'roles.delete', 'roles.permissions',
        //
        'users.view', 'users.create', 'users.edit', 'users.delete',
        // Products
        'products.view', 'products.create', 'products.edit', 'products.delete',

        // Categories
        'categories.view', 'categories.create', 'categories.edit', 'categories.delete',

        //SUBCATEGORIS
        'subcategories.view', 'subcategories.create', 'subcategories.edit', 'subcategories.delete',

        // Coupons
        'coupons.view', 'coupons.create', 'coupons.edit', 'coupons.delete',

        // Orders
        'orders.view', 'orders.create', 'orders.edit', 'orders.delete',

        // Cart & Checkout
        'cart.view', 'cart.add', 'cart.remove', 'checkout.view', 'checkout.place',



        // User profile
        'my_profile.edit',
    ];

    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        foreach ($this->permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        Permission::whereNotIn('name', $this->permissions)->delete();
        $allPermissions = Permission::pluck('name')->toArray();

          // -------------------
        // Admin Role - Full Access
        // -------------------
        $adminRole = Role::updateOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions($allPermissions);

        // Assign Admin role to the main Admin user (email: admin@gmail.com)
        $mainAdmin = User::where('email', 'admin@gmail.com')->first();

        if ($mainAdmin) {
            $mainAdmin->syncRoles(['Admin']);          // Assign Admin role
            $mainAdmin->syncPermissions($allPermissions); // Assign all permissions
        }

        // -------------------
        // Manager Role - Product, Coupon, Category Management
        // -------------------
        $managerPermissions = [
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
            'coupons.view', 'coupons.create', 'coupons.edit', 'coupons.delete',
        ];
        $managerRole = Role::updateOrCreate(['name' => 'Manager']);
        $managerRole->syncPermissions($managerPermissions);

        // -------------------
        // Customer Role - Browse, Cart, Checkout
        // -------------------
        $customerPermissions = [
            'products.view',
            'cart.view', 'cart.add', 'cart.remove',
            'checkout.view', 'checkout.place',
            'my_profile.edit',
        ];
        $customerRole = Role::updateOrCreate(['name' => 'Customer']);
        $customerRole->syncPermissions($customerPermissions);

        // Clear cache after seeding
        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('config:cache');
    }
}
