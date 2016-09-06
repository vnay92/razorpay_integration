<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        $faker = Faker\Factory::create();

        $user = User::create([
            'id' => 1,
            'name' => 'Vinay',
            'email' => 'vnay92@gmail.com',
            'token' => 'asm'
        ]);
    }

}
