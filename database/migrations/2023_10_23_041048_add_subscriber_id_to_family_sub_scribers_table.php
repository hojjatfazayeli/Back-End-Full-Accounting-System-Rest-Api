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
        Schema::table('family_sub_scribers', function (Blueprint $table) {
            $table->foreignId('sub_scriber_id')->constrained('sub_scribers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_sub_scribers', function (Blueprint $table) {
            $table->dropForeign('family_sub_scribers_sub_scriber_id_foreign');
            $table->dropColumn('sub_scriber_id');
        });
    }
};
