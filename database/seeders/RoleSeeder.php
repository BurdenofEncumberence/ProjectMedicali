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
   
        $admin     = Role::create(['name' => 'admin']);
        $pharmacist = Role::create(['name' => 'pharmacist']);
        $manager   = Role::create(['name' => 'inventory_manager']);
        $cashier   = Role::create(['name' => 'cashier']);

       
        Permission::create(['name' => 'view-medicines']);
        Permission::create(['name' => 'manage-medicines']);
        Permission::create(['name' => 'delete-medicines']);
        Permission::create(['name' => 'manage-prescriptions']);
        Permission::create(['name' => 'process-sales']);
        Permission::create(['name' => 'view-reports']);
        Permission::create(['name' => 'manage-users']);

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

  
        $adminUser = User::create([
            'name'              => 'Admin',
            'email'             => 'admin@gmail.com',
            'password'          => Hash::make('admin1234'),
            'email_verified_at' => now(),
        ]);

        $adminUser->assignRole('admin');

        // Pharmacist account
        $pharmacist = User::create([
            'name'              => 'Pharmacist',
            'email'             => 'pharmacist@medicali.com',
            'password'          => Hash::make('pharma1234'),
            'email_verified_at' => now(),
        ]);
        $pharmacist->assignRole('pharmacist');

        // Inventory Manager account
        $manager = User::create([
            'name'              => 'Inventory Manager',
            'email'             => 'manager@medicali.com',
            'password'          => Hash::make('manager1234'),
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('inventory_manager');

        // Cashier account
        $cashier = User::create([
            'name'              => 'Cashier',
            'email'             => 'cashier@medicali.com',
            'password'          => Hash::make('cashier1234'),
            'email_verified_at' => now(),
        ]);
        $cashier->assignRole('cashier');
    }
}