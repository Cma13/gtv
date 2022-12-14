<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointOfInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_of_interests', function (Blueprint $table) {
            $table->id();
            $table->string('name',45);
            $table->string('description',2000);
            $table->decimal('latitude',12,10)->nullable();
            $table->decimal('longitude',13,10)->nullable();
            $table->foreignId('place_id')->references('id')->on('places')->restrictOnDelete();
            $table->foreignId('creator')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('updater')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('point_of_interests');
    }
}
