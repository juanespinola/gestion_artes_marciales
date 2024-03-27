<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $arrayOfPermissionNames = [
            "access",
            "create",
            "update",
            "delete",
        ];

        $arrayOfModulesName = ["user", "federation", "association", "customer"];

        $permissions = [];

        foreach ($arrayOfModulesName as $module) {
            foreach ($arrayOfPermissionNames as $permission) {
                $permissions[] = [
                    "name" => $module.".".$permission,
                    "guard_name" => "web",
                    "group_name" => $module
                ];
            }
        }

        Permission::insert($permissions);
        // create role & give it permissions
        Role::create(["name" => "super-admin"])
            ->givePermissionTo([
                'federation.access',
                'federation.create',
                'federation.update',
                'federation.delete', 
                'user.access',
                'user.create',
                'user.update',
                'user.delete'
            ]);
        // Role::create(["name" => "federation-admin"])->givePermissionTo(Permission::all());
        // Role::create(["name" => "federation-admin"])->givePermissionTo(['access association','create association','update association','delete association',]);
        // Role::create(["name" => "asociation-admin"])->givePermissionTo(['access customer',"update customer"]);

        // Assign roles to users (in this case for user id -> 1 & 2)
        User::find(1)->assignRole('super-admin');
        // User::find(2)->assignRole('federation-admin');
    }
}
