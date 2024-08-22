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
        Schema::table('fiscal_document_items', function (Blueprint $table) {
            $table->foreignId('fiscal_document_id')->constrained('fiscal_documents')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('admins')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fiscal_document_items', function (Blueprint $table) {
            $table->dropForeign('fiscal_document_items_fiscal_document_id_foreign');
            $table->dropForeign('fiscal_document_items_account_id_foreign');
            $table->dropForeign('fiscal_document_items_creator_id_foreign');
            $table->dropColumn('fiscal_document_id');
            $table->dropColumn('account_id');
            $table->dropColumn('creator_id');
        });
    }
};
