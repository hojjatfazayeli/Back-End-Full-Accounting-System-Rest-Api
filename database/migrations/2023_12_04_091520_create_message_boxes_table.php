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
        Schema::create('message_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('sender_role')->default('subscriber');
            $table->string('sender_id')->nullable();
            $table->string('receiver_role')->default('subscriber');
            $table->string('receiver_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_boxes');
    }
};