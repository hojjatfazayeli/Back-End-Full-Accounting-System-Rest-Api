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
        Schema::table('installment_booklets', function (Blueprint $table) {
            $table->foreignId('facility_id')->constrained('facilities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('borrower_id')->constrained('sub_scribers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('admins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('installment_booklets', function (Blueprint $table) {
            $table->dropForeign('installment_booklets_facility_id_foreign');
            $table->dropForeign('installment_booklets_borrower_id_foreign');
            $table->dropForeign('installment_booklets_creator_id_foreign');
            $table->dropColumn('facility_id');
            $table->dropColumn('borrower_id');
            $table->dropColumn('creator_id');
        });
    }
};
