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
        Schema::create('fiscal_documents', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('nature_document')->default('manual');
            $table->string('type_document')->default('facility');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('document_date')->nullable();
            $table->string('serial_code')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('fiscal_year')->nullable();
            $table->string('fiscal_month')->nullable();
            $table->string('status')->default('normal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiscal_documents');
    }
};
