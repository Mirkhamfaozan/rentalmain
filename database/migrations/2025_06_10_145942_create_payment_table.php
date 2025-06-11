<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->unique()->nullable(); // Midtrans transaction ID
            $table->string('payment_type')->nullable(); // e.g., bank_transfer, credit_card, gopay
            $table->decimal('gross_amount', 15, 2); // Total payment amount
            $table->enum('transaction_status', [
                'pending',
                'capture',
                'settlement',
                'deny',
                'cancel',
                'expire',
                'refund',
                'partial_refunded',
                'authorize',
                'failed'
            ])->default('pending'); // Midtrans transaction statuses
            $table->string('fraud_status')->nullable(); // e.g., accept, challenge, deny
            $table->string('bank')->nullable(); // e.g., bca, bni, mandiri
            $table->string('va_number')->nullable(); // Virtual account number for bank transfers
            $table->string('payment_code')->nullable(); // Payment code for certain methods (e.g., QRIS)
            $table->timestamp('transaction_time')->nullable(); // Time of transaction from Midtrans
            $table->timestamp('expiry_time')->nullable(); // Expiry time for pending payments
            $table->text('payment_response')->nullable(); // Raw JSON response from Midtrans
            $table->enum('status', ['pending', 'success', 'failed', 'expired', 'refunded'])->default('pending'); // Internal payment status
            $table->timestamps();
            $table->softDeletes();

            $table->index(['order_id', 'transaction_id', 'transaction_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};