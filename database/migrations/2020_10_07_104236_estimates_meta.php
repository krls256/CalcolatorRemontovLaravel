<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EstimatesMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimatesMeta', function(Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('type', 100);
            $table->string('meta', 100)->nullable();
            $table->integer('estimate_id');
            $table->string('dimension', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimatesMeta');
    }
}
