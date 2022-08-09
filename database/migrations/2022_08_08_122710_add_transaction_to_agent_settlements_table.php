<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionToAgentSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_settlements', function (Blueprint $table) {
            $table->string('tansaction_no')->default('');
            $table->dateTime('tansaction_date')->nullable();
            $table->text('tansaction_details')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_settlements', function (Blueprint $table) {
            //
        });
    }
}
