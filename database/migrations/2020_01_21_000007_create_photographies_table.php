<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotographiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photographies', function (Blueprint $table) {
            $table->id();
            $table->string('route', 245);
            $table->integer('order');
            $table->foreignId('point_of_interest_id')->nullable()->references('id')
                ->on('point_of_interests')->onDelete('cascade');
            $table->foreignId('creator')->nullable()->references('id')
                ->on('users')->nullOnDelete();
            $table->foreignId('updater')->nullable()->references('id')
                ->on('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photographies');
    }
}
