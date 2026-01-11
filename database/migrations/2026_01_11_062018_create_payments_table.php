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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscalyear_id')->constrained()->onDelete('cascade');
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->foreignId('invoice_id')->constrained('invoices');
            $table->foreignId('payment_mode_id')->constrained('payment_modes');
            $table->foreignId('bank_id')->constrained('banks');
            $table->foreignId('receiver_id')->constrained('users');
            $table->string('payment_date');
            $table->string('amount')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_returned')->default(false)->nullable();
            $table->text('return_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
