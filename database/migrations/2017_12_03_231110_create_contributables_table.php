<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributables', function (Blueprint $table) {
            $table->integer('contributor_id')->unsigned();
            $table->foreign('contributor_id')
                ->references('id')->on('contributors')
                ->onDelete('cascade');
            $table->morphs('contributable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributables');
    }
}
