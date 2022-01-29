<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match', function (Blueprint $table) {
            $table->id();
            $table->integer('homeTeam');
            $table->integer('awayTeam');
            $table->timestamp('startTime')->useCurrent();
            $table->timestamp('endTime')->useCurrent();
            $table->integer('league');
            $table->enum('result', ['home', 'away'])->nullable();
            $table->integer('status')->default(1); 
            $table->integer('createdBy'); 
            $table->integer('updatedBy')->default(0); 
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
        Schema::dropIfExists('match');
    }
}
