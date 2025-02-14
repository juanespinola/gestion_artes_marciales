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

        $arrayOfModulesName = [
            "user", 
            "federation", 
            "association", 
            "athlete", 
            "belt",
            "membershiptypes",
            "minorauthorizations",
            "event",
            "country",
            "typesevent",
            "statusevent",
            'new',
            'request',
            'permission',
            'rol',
            'location',
        ];

        $permissions = [];

        foreach ($arrayOfModulesName as $module) {
            foreach ($arrayOfPermissionNames as $permission) {
                $permissions[] = [
                    "name" => $module.".".$permission,
                    "guard_name" => "admins",
                    "group_name" => $module
                ];
            }
        }

        Permission::insert($permissions);
        // create role & give it permissions
        Role::create(["name" => "super-admin"])
            ->givePermissionTo([
                // federation
                'federation.access',
                'federation.create',
                'federation.update',
                'federation.delete', 
                // user
                'user.access',
                'user.create',
                'user.update',
                'user.delete',
               
                // typesevent
                'typesevent.access',
                'typesevent.create',
                'typesevent.update',
                'typesevent.delete',

                // typesevent
                'statusevent.access',
                'statusevent.create',
                'statusevent.update',
                'statusevent.delete',

                // location
                'location.access',
                'location.create',
                'location.update',
                'location.delete',                

                // rol
                'rol.access',
                'rol.create',
                'rol.update',
                'rol.delete',


                // permission
                'permission.access',
                'permission.create',
                'permission.update',
                'permission.delete',
                
                //country
                'country.access',
                'country.create',
                'country.update',
                'country.delete',


                //belt
                'belt.access',
                'belt.create',
                'belt.update',
                'belt.delete',

            ]);
        
            Role::create(["name" => "federation-admin"])
                ->givePermissionTo([
                    // user
                    'user.access',
                    'user.create',
                    'user.update',
                    'user.delete',
                    // association
                    'association.access',
                    'association.create',
                    'association.update',
                    'association.delete',

                    // event
                    'event.access',
                    'event.create',
                    'event.update',
                    'event.delete',
                    
                    // new
                    'new.access',
                    'new.create',
                    'new.update',
                    'new.delete',

                    // request
                    'request.access',
                    'request.create',
                    'request.update',
                    'request.delete',
                    
                    // membershiptypes
                    'membershiptypes.access',
                    'membershiptypes.create',
                    'membershiptypes.update',
                    'membershiptypes.delete',
                   
                    // minorauthorizations
                    'minorauthorizations.access',
                    'minorauthorizations.create',
                    'minorauthorizations.update',
                    'minorauthorizations.delete',
                    
                ]);
            Role::create(["name" => "association-admin"])
            ->givePermissionTo([
        
                // user
                'user.access',
                'user.create',
                'user.update',
                'user.delete',
               
                // event
                'event.access',
                'event.create',
                'event.update',
                'event.delete',

                // new
                'new.access',
                'new.create',
                'new.update',
                'new.delete',

                // request
                'request.access',
                'request.create',
                'request.update',
                'request.delete',

            ]);
        // Role::create(["name" => "federation-admin"])->givePermissionTo(Permission::all());
        // Role::create(["name" => "federation-admin"])->givePermissionTo(['access association','create association','update association','delete association',]);
        // Role::create(["name" => "asociation-admin"])->givePermissionTo(['access customer',"update customer"]);

        // Assign roles to users (in this case for user id -> 1 & 2)
        User::find(1)->assignRole('super-admin');
        User::find(3)->assignRole('federation-admin');
        User::find(4)->assignRole('association-admin');
    }
}
