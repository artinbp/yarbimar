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
            $table->jsonb('colors')->nullable()->default(null);
            $table->jsonb('sizes')->nullable()->default(null);
            $table->string('brand');
            $table->string('manufacturing_country');
            $table->string('weight');
            $table->string('length');
            $table->string('breadth');
            $table->string('width');
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