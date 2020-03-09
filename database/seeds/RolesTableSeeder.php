<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
            ],
            [
                'id'    => 2,
                'title' => 'User',
            ],
        ];
        // DB::beginTransaction();
        // DB::unprepared('SET IDENTITY_INSERT roles ON');
        Role::insert($roles);
        // DB::unprepared('SET IDENTITY_INSERT roles OFF');
        // DB::commit();
    }
}
