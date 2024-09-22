<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiceCarTripTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->decimal('price', 8, 2);
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('destination');
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
        Schema::dropIfExists('pice_car_trip');
    }
}
