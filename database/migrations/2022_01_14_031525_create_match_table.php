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
            $table->string('home_score', 30)->nullable();
            $table->string('away_score', 30)->nullable();
            $table->integer('home_percentage')->default(0);
            $table->integer('draw_percentage')->default(0);
            $table->integer('away_percentage')->default(0);

            $table->enum('status', ['Running', 'Finished','Void'])->default('Running');           
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
