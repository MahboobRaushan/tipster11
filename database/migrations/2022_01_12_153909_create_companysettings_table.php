<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanysettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companysettings', function (Blueprint $table) {
            $table->id();
            $table->string('logo', 255);
            $table->string('favicon', 255);
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('website', 255);
            $table->text('address');
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
        Schema::dropIfExists('companysettings');
    }
}
