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
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('number_first_sheet')->nullable();
            $table->string('number_last_sheet')->nullable();
            $table->string('number_sheet')->nullable();
            $table->string('date_received')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('usable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
