<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('token');
            $table->timestamps();
        });

        // Seeding some sample data
        $faker = Faker\Factory::create();
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Vinay',
            'email' => 'vnay92@gmail.com',
            'token' => 'asm'
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
