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
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_roles', function (Blueprint $table) {
            $table->dropForeign('admin_roles_admin_id_foreign');
            $table->dropForeign('admin_roles_role_id_foreign');
            $table->dropColumn('admin_id');
            $table->dropColumn('role_id');
        });
        Schema::dropIfExists('admin_roles');
    }
};
