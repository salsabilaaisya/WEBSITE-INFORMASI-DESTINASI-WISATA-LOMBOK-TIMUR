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
        Schema::table('galleries', function (Blueprint $table) {
            // Menambahkan kolom 'caption' (nullable agar jika kosong tidak error)
            // Letakkan setelah kolom 'destination_id' atau sesuaikan dengan tabel Anda
            $table->string('caption')->nullable()->after('destination_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Menghapus kembali kolom 'caption' jika migration di-rollback
            $table->dropColumn('caption');
        });
    }
};