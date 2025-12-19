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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // pembuat report
            $table->string('title'); // judul report
            $table->enum('type', ['monthly', 'quarterly', 'annual']); // bulanan, triwulan (3 bln berturut), tahunan
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('total_income', 15, 2)->default(0);
            $table->decimal('total_expenses', 15, 2)->default(0);
            $table->decimal('net_income', 15, 2)->default(0);
            $table->longText('content')->nullable(); // untuk menampung isi laporan yg sangat panjang (termasuk kode html)
            $table->string('file_path')->nullable(); // untuk menyimpan lokasi folder jika kita mengupload file
            $table->timestamps(); // untuk mencatat kapan laporan dibuat dan diperbarui
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
