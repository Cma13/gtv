<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointOfInterestThematicAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_of_interest_thematic_area', function (Blueprint $table) {
            $table->foreignId('thematic_area_id')->references('id')
                ->on('thematic_areas')->onDelete('cascade');

            $table->foreignId('point_of_interest_id')->references('id')
                ->on('point_of_interests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_of_interest_thematic_area');
    }
}
