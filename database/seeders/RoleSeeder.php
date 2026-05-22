<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin      = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $pharmacist = Role::firstOrCreate(['name' => 'pharmacist', 'guard_name' => 'web']);
        $manager    = Role::firstOrCreate(['name' => 'inventory_manager', 'guard_name' => 'web']);
        $cashier    = Role::firstOrCreate(['name' => 'cashier', 'guard_name' => 'web']);

        Permission::firstOrCreate(['name' => 'view-medicines']);
        Permission::firstOrCreate(['name' => 'manage-medicines']);
        Permission::firstOrCreate(['name' => 'delete-medicines']);
        Permission::firstOrCreate(['name' => 'manage-prescriptions']);
        Permission::firstOrCreate(['name' => 'process-sales']);
        Permission::firstOrCreate(['name' => 'view-reports']);
        Permission::firstOrCreate(['name' => 'manage-users']);

        $admin->givePermissionTo(Permission::all());

        $pharmacist->givePermissionTo([
            'view-medicines',
            'manage-prescriptions',
        ]);

        $manager->givePermissionTo([
            'view-medicines',
            'manage-medicines',
            'view-reports',
        ]);

        $cashier->givePermissionTo([
            'view-medicines',
            'process-sales',
        ]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('admin1234'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->assignRole('admin');

        $pharmacistUser = User::firstOrCreate(
            ['email' => 'pharmacist@medicali.com'],
            [
                'name'              => 'Pharmacist',
                'password'          => Hash::make('pharma1234'),
                'email_verified_at' => now(),
            ]
        );
        $pharmacistUser->assignRole('pharmacist');

        $managerUser = User::firstOrCreate(
            ['email' => 'manager@medicali.com'],
            [
                'name'              => 'Inventory Manager',
                'password'          => Hash::make('manager1234'),
                'email_verified_at' => now(),
            ]
        );
        $managerUser->assignRole('inventory_manager');

        $cashierUser = User::firstOrCreate(
            ['email' => 'cashier@medicali.com'],
            [
                'name'              => 'Cashier',
                'password'          => Hash::make('cashier1234'),
                'email_verified_at' => now(),
            ]
        );
        $cashierUser->assignRole('cashier');
    }
}