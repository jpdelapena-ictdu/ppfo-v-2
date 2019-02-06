<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_type' => 1,
            'status' => 'active',
            'name' => str_random(10),
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin1234'),
        ]);
    }
}
