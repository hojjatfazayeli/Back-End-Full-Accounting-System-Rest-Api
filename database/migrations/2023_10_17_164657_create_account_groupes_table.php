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
        Schema::create('account_groupes', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('fiscal_year')->nullable();
            $table->string('title')->nullable();
            $table->string('total_code')->nullable();
            $table->string('type_account')->default('permanent');
            $table->string('nature_account')->default('debtor');
            $table->string('status_account')->nullable('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_groupes');
    }
};
