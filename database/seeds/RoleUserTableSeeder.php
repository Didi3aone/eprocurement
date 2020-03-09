<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        // DB::beginTransaction();
        // DB::unprepared('SET IDENTITY_INSERT users ON');
        User::findOrFail(1)->roles()->sync(1);
        // DB::unprepared('SET IDENTITY_INSERT users OFF');
        // DB::commit();
    }
}
