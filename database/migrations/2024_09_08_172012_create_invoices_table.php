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
        Schema::create('invoices', function (Blueprint $table) {
			$table->id();
            $table->date('date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('shopname')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile_no')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=Complete, 1=Draft');
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('return_amount', 10, 2)->nullable();
            $table->integer('percentage_discount')->nullable();
            $table->decimal('flat_discount', 10, 2)->nullable();
            $table->decimal('shipping', 10, 2)->nullable();
            $table->decimal('labour', 10, 2)->nullable();
            $table->decimal('payable_amount', 10, 2)->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('due_amount', 10, 2)->nullable();
            $table->decimal('previous_due_amount', 10, 2)->default(0);
            $table->string('transaction_type')->nullable();
            $table->text('comment')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
