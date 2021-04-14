<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('company');
            $table->string('review_id', 50);
            $table->string('provider', 20);
            $table->integer('rating');
            $table->string('user', 100);
            $table->text('text');
            $table->string('date', 20);
            $table->text('img')->nullable();
            $table->string('status', 15)->nullable()->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
