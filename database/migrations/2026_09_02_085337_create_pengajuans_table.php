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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->enum('tipe_pengajuan', ['Sepeda Motor', 'Mobil', 'Multiguna']);
            $table->decimal('nominal_pengajuan', 15, 2);
            $table->integer('tenor');
            $table->enum('status', ['pending', 'setuju', 'tolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->decimal('tagihan_per_bulan', 15, 2)->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->date('tanggal_persetujuan')->nullable();
            $table->timestamps();

            $table->index('customer_id');
            $table->index('tipe_pengajuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
