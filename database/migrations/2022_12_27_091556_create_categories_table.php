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
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable(false);
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->text("description")->nullable();
            $table->boolean('disabled')->default(false);
            $table->integer('depth')->unsigned();
            $table->timestamps();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
