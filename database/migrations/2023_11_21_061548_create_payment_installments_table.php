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
        Schema::create('payment_installments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('payment_type')->default('other');
            $table->string('payment_date')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_tracking_code')->nullable();
            $table->string('card_number')->nullable();
            $table->string('file')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('payment_installments');
    }
};
