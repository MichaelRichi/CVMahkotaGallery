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
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            
            $table->decimal('jumlah_hutang', 12, 2);
            $table->integer('periode_pelunasan'); // dalam bulan
            $table->date('start_pelunasan');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['ONGOING', 'LUNAS', 'BATAL'])->default('ONGOING');
            $table->decimal('sisa_hutang', 12, 2);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('staff');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang');
    }
};
