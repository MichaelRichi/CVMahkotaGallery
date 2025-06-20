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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->integer('periode_pelunasan');
            $table->decimal('jumlah_pinjaman');
            $table->string('alasan');
            $table->date('start_pelunasan');
            $table->boolean('validasi_admin')->default(false);
            $table->enum('status', ['LUNAS','BATAL','ONGOING'])->nullable();
            $table->decimal('sisa_pinjaman')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
