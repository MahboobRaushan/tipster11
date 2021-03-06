<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pools', function (Blueprint $table) {
            $table->id(); 
            $table->string('name',255);          
            $table->timestamp('startTime');
            $table->timestamp('endTime');
            $table->integer('perBetAmount');
            $table->integer('basePrice');
            $table->double('megaPercentage', 8, 2);
            $table->double('poolPercentage', 8, 2);
            $table->double('comPercentage', 8, 2);
            $table->double('agentPercentage', 8, 2); 
            $table->double('group1Percentage', 8, 2); 
            $table->double('group2Percentage', 8, 2);
            $table->double('group3Percentage', 8, 2);

            $table->integer('group1TotalPlayer');
            $table->integer('group2TotalPlayer');
            $table->integer('group3TotalPlayer');

            $table->double('group1TotalPrize', 9, 2);
            $table->double('group2TotalPrize', 9, 2);
            $table->double('group3TotalPrize', 9, 2);


            $table->boolean('isJackpotPool')->default(false);            
            $table->enum('status', ['Inactive', 'Active','Calculating','Finished'])->default('Inactive'); 
            $table->enum('currentStatus', ['Need Calculate','Calculating','Finished'])->default('Need Calculate');

            

            $table->integer('createdBy')->default(0); 
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
        Schema::dropIfExists('pools');
    }
}
