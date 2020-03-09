<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$w/mSl8C3ALR0RC2eLJjrwe6fSvRJ4sT3JcPcE0yMZuVWZcpU27Gp2',
                'remember_token' => null,
                'nik'            => 190256,
                'department_id'  => 'ICT100'
            ],
        ];
        // DB::beginTransaction();
        // DB::unprepared('SET IDENTITY_INSERT users ON');
        User::insert($users);
        // DB::unprepared('SET IDENTITY_INSERT users OFF');
        // DB::commit();
    }
}
