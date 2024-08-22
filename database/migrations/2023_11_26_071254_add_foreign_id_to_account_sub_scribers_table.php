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
        Schema::table('account_sub_scribers', function (Blueprint $table) {
            $table->foreignId('sub_scriber_id')->constrained('sub_scribers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_sub_scribers', function (Blueprint $table) {
            $table->dropForeign('account_sub_scribers_sub_scriber_id_foreign');
            $table->dropForeign('account_sub_scribers_account_id_foreign');
            $table->dropColumn('sub_scriber_id');
            $table->dropColumn('account_id');
        });
    }
};
