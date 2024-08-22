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
        Schema::table('receipts', function (Blueprint $table) {
            $table->foreignId('fiscal_document_id')->constrained('fiscal_documents')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('bank_list_id')->constrained('bank_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('admins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropForeign('receipts_fiscal_document_id_foreign');
            $table->dropForeign('receipts_bank_list_id_foreign');
            $table->dropForeign('receipts_creator_id_foreign');
            $table->dropColumn('fiscal_document_id');
            $table->dropColumn('bank_list_id');
            $table->dropColumn('creator_id');
        });
    }
};
