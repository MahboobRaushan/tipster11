<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_transactions', function (Blueprint $table) {
            $table->id();
             $table->integer('bet_id');
             $table->integer('user_id');
             $table->integer('pool_id');
             $table->integer('perBetAmount');
             $table->double('megaAmount', 8, 2);
              $table->double('poolAmount', 8, 2);
               $table->double('comAmount', 8, 2);
                $table->double('agentAmount', 8, 2);
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
        Schema::dropIfExists('bet_transactions');
    }
}
