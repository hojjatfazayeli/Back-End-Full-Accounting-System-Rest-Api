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
        Schema::table('fiscal_documents', function (Blueprint $table) {
            $table->foreignId('cheque_id')->nullable()->constrained('cheques')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cheque_sheet_id')->nullable()->constrained('cheque_sheets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('admins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fiscal_documents', function (Blueprint $table) {
            $table->dropForeign('fiscal_documents_cheque_id_foreign');
            $table->dropForeign('fiscal_documents_creator_id_foreign');
            $table->dropForeign('fiscal_documents_cheque_sheet_id_foreign');
            $table->dropColumn('cheque_id');
            $table->dropColumn('creator_id');
            $table->dropColumn('cheque_sheet_id');
        });
    }
};
