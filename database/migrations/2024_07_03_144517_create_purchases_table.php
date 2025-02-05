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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
			$table->string('purchase_no');
			$table->integer('supplier_id');
			$table->date('date');
			$table->string('transaction_type');
			$table->decimal('discount_amount', 10, 2)->default(0);
			$table->decimal('shipping', 10, 2)->default(0);
			$table->decimal('paid_amount', 10, 2)->default(0);
			$table->decimal('estimated_amount', 10, 2)->default(0);
			$table->decimal('due_amount', 10, 2)->default(0);
			$table->tinyInteger('status')->default(0)->comment('0=Pending, 1=Approved');
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
        Schema::dropIfExists('purchases');
    }
};
