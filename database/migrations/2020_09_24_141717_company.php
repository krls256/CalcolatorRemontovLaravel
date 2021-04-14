<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Company extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->string('name');
            $table->string('logo');
            $table->bigInteger('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('site')->nullable();
            $table->timestamp('create')->useCurrent();
            $table->string('youtube')->nullable();
            $table->string('yell_id', 30)->nullable();
            $table->string('flamp_id', 30)->nullable();
            $table->string('yandex_id', 30)->nullable();
            $table->text('discription')->nullable();
            $table->decimal('rating_reviews', 10, 1)->nullable()->default(0);
            $table->decimal('rating_profile', 10, 1)->nullable()->default(0);
            $table->string('email', 100)->nullable();
            $table->string('estimate')->nullable();
            $table->bigInteger('redecorating', false)->nullable();
            $table->bigInteger('overhaul', false)->nullable();
            $table->bigInteger('turnkey_repair', false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
