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
        Schema::create('fiscal_document_items', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('description')->nullable();
            $table->string('deptor')->nullable();
            $table->string('creditor')->nullable();
            $table->string('status')->default('normal');
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
        Schema::dropIfExists('fiscal_document_items');
    }
};
