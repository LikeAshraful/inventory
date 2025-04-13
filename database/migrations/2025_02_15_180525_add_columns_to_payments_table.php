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
            $table->date('payment_date')->nullable()->after('previous_due_amount');
            $table->double('discount')->nullable()->after('payment_date');
            $table->string('note')->nullable()->after('discount');
            $table->unsignedBigInteger('created_by')->after('note');
            $table->unsignedBigInteger('invoice_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_date');
            $table->dropColumn('discount');
            $table->dropColumn('note');
            $table->dropColumn('created_by');
            $table->unsignedBigInteger('invoice_id')->nullable(false)->change();
        });
    }
};
