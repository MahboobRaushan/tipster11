<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->dateTime('deposit_time', $precision = 0)->nullable();
            $table->integer('before_deposit_amount')->default(0);
            $table->integer('amount')->default(0);
            $table->integer('current_balance')->default(0);
            $table->string('transaction_no');
            $table->text('transaction_details');
            $table->text('status_change_message')->nullable();            
            $table->string('transaction_document');
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
        Schema::dropIfExists('deposits');
    }
}
