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
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->nullable()->default(null);
            $table->string('provider')->nullable()->default(null);
            $table->string('reference_number')->nullable()->default(null);
            $table->decimal('amount');
            $table->enum('status', ['pending', 'paid', 'failed']);
            $table->timestamps();

            $table->unique(['number', 'provider']);
//            $table->integer('invoice_id');
//            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
