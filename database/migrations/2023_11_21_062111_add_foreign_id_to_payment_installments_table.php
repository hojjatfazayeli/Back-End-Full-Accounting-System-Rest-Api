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
        Schema::table('payment_installments', function (Blueprint $table) {
            $table->foreignId('installment_booklet_id')->constrained('installment_booklets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('facility_id')->constrained('facilities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('payer_id')->constrained('sub_scribers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('bank_list_id')->constrained('bank_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('checker_id')->nullable()->constrained('admins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_installments', function (Blueprint $table) {
            $table->dropForeign('payment_installments_installment_booklet_id_foreign');
            $table->dropForeign('payment_installments_facility_id_foreign');
            $table->dropForeign('payment_installments_payer_id_foreign');
            $table->dropForeign('payment_installments_bank_list_id_foreign');
            $table->dropForeign('payment_installments_checker_id_foreign');
            $table->dropColumn('installment_booklet_id');
            $table->dropColumn('facility_id');
            $table->dropColumn('payer_id');
            $table->dropColumn('bank_list_id');
            $table->dropColumn('checker_id');
        });
    }
};
