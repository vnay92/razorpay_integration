<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('amount');
            $table->string('order_id');
            $table->string('status');
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
        });

        DB::table('transactions')->insert([
            'id' => 1,
            'user_id' => 1,
            'amount' => 500,
            'status' => 'PENDING'
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}
