<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscalyear_id')->constrained()->onDelete('cascade');
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_mode_id')->constrained('payment_modes');
            $table->foreignId('bank_id')->constrained('banks');
            $table->foreignId('expense_category_id')->constrained('banks');
            $table->foreignId('expense_by')->constrained('users');
            $table->string('title')->nullable();
            $table->string('payment_date');
            $table->string('amount')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
