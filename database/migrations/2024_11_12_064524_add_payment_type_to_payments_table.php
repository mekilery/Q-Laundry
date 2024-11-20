<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTypeToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add the payment_type column and set it as a foreign key
            $table->unsignedBigInteger('payment_type')->nullable();
            $table->foreign('payment_type')->references('id')->on('payment_types')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop the foreign key and the column
            $table->dropForeign(['payment_type']);
            $table->dropColumn('payment_type');
        });
    }
}
