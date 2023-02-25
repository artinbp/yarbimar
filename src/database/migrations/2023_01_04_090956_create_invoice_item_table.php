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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned()->nullable()->default(null);
            $table->integer('product_id')->unsigned()->nullable()->default(null);
            $table->integer('shipping_method_id')->unsigned()->nullable()->default(null);
            $table->integer('quantity')->unsigned();
            $table->decimal('price')->unsigned();
            $table->decimal('discount')->unique()->nullable()->default(null);
            $table->decimal('amount')->unsigned();
            $table->text('description')->nullable()->default(null);
            $table->integer('payment_id')->unsigned()->nullable()->default(null);
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_item');
    }
};
