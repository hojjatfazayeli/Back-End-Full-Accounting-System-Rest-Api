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
        Schema::table('fiscal_transactions', function (Blueprint $table) {
            $table->foreignId('bank_list_id')->constrained('bank_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sub_scriber_id')->constrained('sub_scribers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('checker_id')->nullable()->constrained('admins')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fiscal_transactions', function (Blueprint $table) {
            $table->dropForeign('fiscal_transactions_bank_list_id_foreign');
            $table->dropForeign('fiscal_transactions_sub_scriber_id_foreign');
            $table->dropForeign('fiscal_transactions_checker_id_foreign');
            $table->dropColumn('bank_list_id');
            $table->dropColumn('sub_scriber_id');
            $table->dropColumn('checker_id');
        });
    }
};
