<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverInfoModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_info_models', function (Blueprint $table) {
            $table->id();
            $table->string('adhar_front');
            $table->string('adhar_back');
            $table->string('driving_licence_front');
            $table->string('driving_licence_back');
            $table->string('passport_photo');
            $table->string('digital_photo');
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
        Schema::dropIfExists('driver_info_models');
    }
}
