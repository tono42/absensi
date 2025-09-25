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
       Schema::create('izins', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->date('tanggal_mulai');
    $table->date('tanggal_selesai');
    $table->string('jenis_izin'); // Sakit, Cuti, Izin Lain
    $table->text('keterangan');
    $table->string('file_bukti')->nullable(); // Path ke file bukti
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status validasi admin
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};
