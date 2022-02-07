<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
             $table->integer('user_id')->default(0);
            $table->dateTime('withdraw_time', $precision = 0)->nullable();
            $table->integer('before_withdraw_amount')->default(0);
            $table->integer('amount')->default(0);
            $table->integer('current_balance')->default(0);
            $table->string('bank_account_name', 255)->nullable();
            $table->string('bank_country', 100)->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_account_number', 32)->nullable();
            $table->string('bank_account_type', 32)->nullable(); 
            $table->text('status_change_message')->nullable(); 
            $table->enum('status', ['Pending', 'Approved','Reject'])->default('Pending');            
            $table->integer('createdBy')->default(0); 
            $table->integer('responsedBy')->default(0); 
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
        Schema::dropIfExists('withdraws');
    }
}
