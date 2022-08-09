<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_settlements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->dateTime('from_date',$precision=0)->nullable();
            $table->dateTime('to_date',$precision=0)->nullable();
            $table->double('total_commission',8,2)->default(0.0);
            $table->double('settlement_amount',8,2)->default(0.0);
            $table->longText('agent_comments')->default('');
            $table->longText('company_comments')->default('');
            $table->enum('agent_status',['Submit'])->default('Submit');
            $table->enum('company_status',['Pending','Approved','Rejected'])->default('Pending');
            $table->dateTime('agent_apply_date',$precision=0)->nullable();
            $table->dateTime('company_action_date',$precision=0)->nullable();
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
        Schema::dropIfExists('agent_settlements');
    }
}
