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
        Schema::table('fiscal_years_items', function (Blueprint $table) {
            $table->foreignId('fiscal_year_id')->constrained('fiscal_years')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fiscal_years_items', function (Blueprint $table) {
            $table->dropForeign('fiscal_years_items_fiscal_year_id_foreign');
            $table->dropForeign('fiscal_years_items_creator_id_foreign');
            $table->dropColumn('fiscal_year_id');
            $table->dropColumn('creator_id');
        });
    }
};
