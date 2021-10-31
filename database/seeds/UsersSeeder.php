<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Master', 'email' => 'master@gmail.com', 'role_id' => 1, 'password' => Hash::make('!!minda123'), ],
        ]);
    }
}
