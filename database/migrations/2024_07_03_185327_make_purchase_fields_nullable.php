<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePurchaseFieldsNullable extends Migration
{
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->decimal('discount_amount', 10, 2)->nullable()->change();
            $table->decimal('shipping', 10, 2)->nullable()->change();
            $table->decimal('paid_amount', 10, 2)->nullable()->change();
            $table->decimal('due_amount', 10, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->decimal('discount_amount', 10, 2)->nullable(false)->change();
            $table->decimal('shipping', 10, 2)->nullable(false)->change();
            $table->decimal('paid_amount', 10, 2)->nullable(false)->change();
            $table->decimal('due_amount', 10, 2)->nullable(false)->change();
        });
    }
}
