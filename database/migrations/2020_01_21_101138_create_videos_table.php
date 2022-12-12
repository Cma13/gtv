<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('route', 245);
            $table->foreignId('point_of_interest_id')->nullable()->references('id')->on('point_of_interests')->onDelete('cascade');
            $table->integer('order');
            $table->foreignId('creator')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('updater')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('description', 2000);
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
        Schema::dropIfExists('videos');
    }
}
