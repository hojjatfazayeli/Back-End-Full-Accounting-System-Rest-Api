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
        Schema::create('installment_booklets', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('nature_installment')->default('receipt');
            $table->string('type_installment')->default('initial');
            $table->string('payment_year')->nullable();
            $table->string('payment_month')->nullable();
            $table->string('amount_installment')->nullable();
            $table->string('status')->default('unpaid');
            $table->string('fiscal_year')->nullable();
            $table->string('fiscal_month')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_booklets');
    }
};
