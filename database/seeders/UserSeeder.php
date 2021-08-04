<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => '1',
            'name' => 'Nguyễn Thế Công',
            'email' => 'thecong1996@gmail.com',
            'password' =>  Hash::make('123456'),
            'phone' => '0987992154',
            'account' => 'congnt',
        ]);

        Role::create([
            'user_code' => 'ADMIN',
            'status' => '9',
            'user_id' => '1',
        ]);
    }
}
