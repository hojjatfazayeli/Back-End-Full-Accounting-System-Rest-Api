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
        Schema::table('cheque_sheets', function (Blueprint $table) {
            $table->foreignId('cheque_id')->constrained('cheques')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cheque_sheets', function (Blueprint $table) {
            $table->dropForeign('cheque_sheets_cheque_id_foreign');
            $table->dropColumn('cheque_id');
        });
    }
};
