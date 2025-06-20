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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->char('NIK',16)->unique();
            $table->string('nama');
            $table->enum('JK', ['L', 'P']);
            $table->date('TTL');
            $table->string('notel');
            $table->string('alamat');
            $table->date('tgl_masuk');
            $table->date('tgl_keluar');
            $table->decimal('gaji_pokok');
            $table->decimal('gaji_tunjangan');
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
