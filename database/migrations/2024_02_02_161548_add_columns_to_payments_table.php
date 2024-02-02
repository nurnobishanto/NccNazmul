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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('trx_id')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('currency')->nullable();
            $table->string('intent')->nullable();
            $table->dateTime('payment_execute_time')->nullable();
            $table->string('merchant_invoice_number')->nullable();
            $table->string('payer_reference')->nullable();
            $table->string('customer_msisdn')->nullable();
            $table->string('status_code')->nullable();
            $table->string('status_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
    }
};
