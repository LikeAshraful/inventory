<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Make supplier_id and unit_id nullable
            $table->integer('supplier_id')->nullable()->change();
            $table->integer('unit_id')->nullable()->change();

            // Change buying_price, retail_sale, and wholesale to decimal with default 0
            $table->decimal('buying_price', 10, 2)->default(0)->change();
            $table->decimal('retail_sale', 10, 2)->default(0)->change();
            $table->decimal('wholesale', 10, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert supplier_id and unit_id to not nullable
            $table->integer('supplier_id')->nullable(false)->change();
            $table->integer('unit_id')->nullable(false)->change();

            // Revert buying_price, retail_sale, and wholesale to string
            $table->string('buying_price')->nullable()->change();
            $table->string('retail_sale')->nullable()->change();
            $table->string('wholesale')->nullable()->change();
        });
    }
};
