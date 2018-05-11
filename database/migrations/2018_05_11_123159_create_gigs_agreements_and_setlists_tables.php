<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGigsAgreementsAndSetlistsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gigs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('venue');
            $table->dateTime('date');
            $table->integer('payout')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->integer('setlist_id')->nullable()->unsigned();
            $table->integer('agreement_id')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::create('setlists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('gig_id')->nullable()->unsigned();
            $table->text('setlist');
            $table->text('setlist_md');
            $table->timestamps();
        });

        Schema::create('agreements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('file_path');
            $table->integer('gig_id')->nullable()->unsigned();
            $table->timestamps();
        });

        /**
         * Foreign keys.
         */

         Schema::table('gigs', function (Blueprint $table) {
             $table->foreign('setlist_id')->references('id')->on('setlists')->onDelete('set null');
             $table->foreign('agreement_id')->references('id')->on('agreements')->onDelete('set null');
         });
         
         Schema::table('setlists', function (Blueprint $table) {
            $table->foreign('gig_id')->references('id')->on('gigs')->onDelete('set null');
        });

        Schema::table('agreements', function (Blueprint $table) {
            $table->foreign('gig_id')->references('id')->on('gigs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gigs');
        Schema::dropIfExists('setlists');
        Schema::dropIfExists('agreements');
    }
}
