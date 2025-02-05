<?php

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
			Schema::table('invoices', function (Blueprint $table) {
				$table->string('sale_type')->default('retail')->after('id'); // Default মান 'retail'
			});
		}

		public function down()
		{
			Schema::table('invoices', function (Blueprint $table) {
				$table->dropColumn('sale_type');
			});
		}

};
