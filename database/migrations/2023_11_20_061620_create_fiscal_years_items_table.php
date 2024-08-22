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
        Schema::create('fiscal_years_items', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('amount_membershipـright_month')->nullable();
            $table->string('amount_participate_right')->nullable();
            $table->string('amount_membership_fee')->nullable();
            $table->string('amount_motivational')->nullable();
            $table->string('fee_percentage')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiscal_years_items');
    }
};
