<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->boolean('verified')->default(false);
        });

        Schema::table('point_of_interests', function (Blueprint $table) {
            $table->boolean('verified')->default(false);
        });

        Schema::table('photographies', function (Blueprint $table) {
            $table->boolean('verified')->default(false);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('verified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn('verified');
        });

        Schema::table('point_of_interests', function (Blueprint $table) {
            $table->dropColumn('verified');
        });

        Schema::table('photographies', function (Blueprint $table) {
            $table->dropColumn('verified');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('verified');
        });
    }
};
