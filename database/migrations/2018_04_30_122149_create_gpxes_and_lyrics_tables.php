<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGPXesAndLyricsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('gpx', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('filePath');
            $table->float('version');
            $table->integer('user_id')->unsigned();
            $table->integer('lyric_id')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::create('lyrics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('md_text');
            $table->text('text');
            $table->integer('gpx_id')->nullable()->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        /**
         * Foreign keys.
         */

        Schema::table('gpx', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lyric_id')->references('id')->on('lyrics')->onDelete('set null');
        });
        Schema::table('lyrics', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gpx_id')->references('id')->on('gpx')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gpx');
        Schema::dropIfExists('lyrics');
    }
}
