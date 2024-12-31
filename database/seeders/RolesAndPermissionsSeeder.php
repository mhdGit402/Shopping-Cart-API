<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            // Create permissions
            $permissions = [
                'create product',
                'edit product',
                'delete product',
                'view product',
                'create cart',
                'edit cart',
                'delete cart',
                'view cart',
                'view all carts',
                'view tokens'
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }

            // Create roles and assign permissions
            $adminRole = Role::firstOrCreate(['name' => 'admin']);
            $adminRole->syncPermissions($permissions); // Assign all permissions to admin

            $maintainerRole = Role::firstOrCreate(['name' => 'maintainer']);
            $maintainerRole->syncPermissions(['create product', 'edit product', 'view product', 'view cart', 'view all carts', 'view tokens']);

            $userRole = Role::firstOrCreate(['name' => 'user']);
            $userRole->syncPermissions(['view product', 'view cart', 'delete cart']);
        }
    }
}
