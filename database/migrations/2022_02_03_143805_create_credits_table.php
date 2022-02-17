<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);           
            $table->integer('before_deposit_withdraw_amount')->default(0);
            $table->integer('amount')->default(0);
            $table->integer('current_balance')->default(0);
            $table->enum('type', ['Deposit', 'Withdraw'])->nullable(); 
            $table->enum('reference_by', ['Self', 'Company'])->default('Self'); 
            $table->integer('deposit_withdraw_id')->default(0); 
            $table->integer('createdBy')->default(0); 
            $table->text('remarks')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits');
    }
}
