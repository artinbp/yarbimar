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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->decimal('price')->unsigned();
            $table->integer('stock')->unsigned();
            $table->text('thumbnail_path');
            $table->string('color');
            $table->decimal('size');
            $table->string('brand');
            $table->string('manufacturing_country');
            $table->decimal('weight');
            $table->decimal('length');
            $table->decimal('breadth');
            $table->decimal('width');
            $table->timestamps();

            $table->fullText(['title', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
