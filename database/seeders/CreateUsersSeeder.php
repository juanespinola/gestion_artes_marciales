<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\UserType;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Admin User',
               'email'=>'admin@gmail.com',
            //    'type'=> UserType::ADMIN,
               'password'=> bcrypt('123456'),
            ],
            [
               'name'=>'User',
               'email'=>'user@gmail.com',
            //    'type'=>UserType::USER,
               'password'=> bcrypt('123456'),
            ],
            [
                'name'=>'Federacion User',
                'email'=>'federacion@gmail.com',
                'password'=> bcrypt('123456'),
                'federation_id'=> '1',
            ],
            [
                'name'=>'Asociacion 2 User',
                'email'=>'asociacion@gmail.com',
                'password'=> bcrypt('123456'),
                'federation_id'=> '1',
                'association_id'=> '2',
            ],
            [
                'name'=>'Asociacion 1 User',
                'email'=>'asociacion1@gmail.com',
                'password'=> bcrypt('123456'),
                'federation_id'=> '1',
                'association_id'=> '1',
            ],
        ];


        foreach ($users as $key => $user) {

            User::create($user);

        }
    }
}
