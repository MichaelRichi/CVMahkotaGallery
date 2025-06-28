@extends('layouts.app')

@section('title', 'Ajukan Pinjaman')
@section('page-title', 'Ajukan Pinjaman')
@section('page-description', 'Buat pengajuan pinjaman baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Form Pengajuan Pinjaman</h2>
                <p class="text-gray-400">Lengkapi form di bawah untuk mengajukan pinjaman</p>
            </div>
            {{-- <a href="{{ route('pinjaman.view') }}" class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a> --}}
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="glass-card rounded-2xl p-4 border border-green-500/30 bg-green-500/10">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-400 mr-3"></i>
                <p class="text-green-300">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
            <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
            Informasi Pinjaman
        </h3>

        <form action="{{ route('pinjaman.add') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Jumlah Pinjaman -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-money-bill-wave mr-1 text-yellow-400"></i>
                    Jumlah Pinjaman
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                    <input type="number" name="jumlah_pinjaman" value="{{ old('jumlah_pinjaman') }}" min="100000" max="100000000" step="50000"
                           class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="0" required>
                </div>
                @error('jumlah_pinjaman')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Periode Pelunasan -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-calendar-alt mr-1 text-yellow-400"></i>
                    Periode Pelunasan
                </label>
                <select name="periode_pelunasan"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                        required>
                    <option value="">Pilih periode pelunasan</option>
                    <option value="6" {{ old('periode_pelunasan') == '6' ? 'selected' : '' }}>6 Bulan</option>
                    <option value="12" {{ old('periode_pelunasan') == '12' ? 'selected' : '' }}>12 Bulan</option>
                    <option value="18" {{ old('periode_pelunasan') == '18' ? 'selected' : '' }}>18 Bulan</option>
                    <option value="24" {{ old('periode_pelunasan') == '24' ? 'selected' : '' }}>24 Bulan</option>
                    <option value="36" {{ old('periode_pelunasan') == '36' ? 'selected' : '' }}>36 Bulan</option>
                </select>
                @error('periode_pelunasan')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Alasan -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-align-left mr-1 text-yellow-400"></i>
                    Alasan Pengajuan
                </label>
                <textarea name="alasan" rows="4"
                          class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                          placeholder="Jelaskan alasan pengajuan pinjaman..." required>{{ old('alasan') }}</textarea>
                @error('alasan')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6">
                <a href="{{ route('pinjaman.view') }}" class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Ajukan Pinjaman
                </button>
            </div>
        </form>
    </div>

    <!-- Information -->
    <div class="glass-card rounded-2xl p-6 border border-blue-500/30 bg-blue-500/10">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-400 mr-3 mt-1"></i>
            <div>
                <h4 class="text-blue-400 font-semibold mb-2">Informasi Pinjaman</h4>
                <ul class="text-blue-300 text-sm space-y-1">
                    <li>• Proses persetujuan 1-3 hari kerja setelah pengajuan</li>
                    <li>• Pembayaran cicilan setiap tanggal yang sama setiap bulan</li>
                    <li>• Anda dapat memantau status pengajuan di halaman riwayat</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
