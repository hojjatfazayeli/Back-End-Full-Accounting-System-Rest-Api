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
        Schema::table('sub_scribers', function (Blueprint $table) {
            $table->foreignId('creator_id')->constrained('admins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_scribers', function (Blueprint $table) {
            $table->dropForeign('sub_scribers_creator_id_foreign');
            $table->dropColumn('creator_id');
        });
    }
};