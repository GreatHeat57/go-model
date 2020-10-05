<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnAdditionalChargesInPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function ($table) {
            $table->decimal('packege_price')->after('transaction_id')->nullable()->default(NULL);
            $table->decimal('tax_price')->after('packege_price')->nullable()->default(NULL);
            $table->text('additional_charges')->after('tax_price')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('packege_price');
            $table->dropColumn('tax_price');
            $table->dropColumn('additional_charges');
        });
    }
}
