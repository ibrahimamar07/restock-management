<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations (Menambahkan kolom).
     */
    public function up(): void
    {
        Schema::table('user_payment_types', function (Blueprint $table) {
            // Menambahkan kolom 'is_default' sebagai boolean (0 atau 1)
            // default diatur ke false (0), dan diletakkan setelah kolom 'paymentDetails'
            $table->boolean('is_default')->default(false)->after('paymentDetails');
        });
    }

    /**
     * Reverse the migrations (Menghapus kolom).
     */
    public function down(): void
    {
        Schema::table('user_payment_types', function (Blueprint $table) {
            // Menghapus kolom 'is_default' saat migrasi di-rollback
            $table->dropColumn('is_default');
        });
    }
};
