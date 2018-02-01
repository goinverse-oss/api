<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('media_url')->nullable();
            $table->string('player_url')->nullable();
            $table->string('permalink_url')->nullable();
            $table->date('published_at')->nullable();
            $table->string('status')->nullable();
            $table->integer('number')->nullable();
            $table->integer('season_id')->unsigned()->nullable();
            $table->foreign('season_id')
                ->references('id')->on('seasons')
                ->onDelete('cascade');
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
        Schema::table('episodes', function(Blueprint $table) {
            $table->dropForeign(['season_id']);
        });
        Schema::dropIfExists('episodes');
    }
}
