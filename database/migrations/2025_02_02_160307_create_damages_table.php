<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('damages', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('product_id');
			$table->string('reasons')->nullable();
			$table->integer('product_in')->default(0); // If a product is restored
			$table->integer('product_out')->default(0); // If a product is lost
			$table->date('date');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->timestamps();
		});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damages');
    }
};
