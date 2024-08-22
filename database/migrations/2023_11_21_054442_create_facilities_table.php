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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('code')->nullable();
            $table->string('title')->nullable();
            $table->string('amount_facility')->nullable();
            $table->string('start_installment_date')->nullable();
            $table->string('quantity_installments')->nullable();
            $table->string('amount_first_installment')->nullable();
            $table->string('amount_other_installment')->nullable();
            $table->string('payment_date')->nullable();
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
        Schema::dropIfExists('facilities');
    }
};
