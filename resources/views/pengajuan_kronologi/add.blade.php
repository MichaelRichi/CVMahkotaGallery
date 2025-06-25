@extends('layouts.app')

@section('title', 'Ajukan Kronologi')
@section('page-title', 'Ajukan Kronologi')
@section('page-description', 'Buat pengajuan kronologi baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Form Pengajuan Kronologi</h2>
                <p class="text-gray-400">Lengkapi form di bawah untuk mengajukan kronologi</p>
            </div>
            <a href="{{ route('kronologi.view') }}" class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
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
            <i class="fas fa-file-alt mr-2 text-yellow-400"></i>
            Informasi Pengajuan
        </h3>

        <form action="{{ route('kronologi.add') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-heading mr-1 text-yellow-400"></i>
                    Judul Pengajuan
                </label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                       placeholder="Masukkan judul pengajuan kronologi" required>
                @error('judul')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Barang -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-box mr-1 text-yellow-400"></i>
                    Nama Barang
                </label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                       placeholder="Masukkan nama barang yang diajukan" required>
                @error('nama_barang')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Harga Barang -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-money-bill-wave mr-1 text-yellow-400"></i>
                    Harga Barang
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                    <input type="number" name="harga_barang" value="{{ old('harga_barang') }}" min="0"
                           class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="0" required>
                </div>
                @error('harga_barang')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- periode -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-money-bill-wave mr-1 text-yellow-400"></i>
                    Berapa kali bayar
                </label>
                <div class="relative">
                    <input type="number" name="periode_pelunasan" value="{{ old('periode_pelunasan') }}" min="0"
                           class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="0" required>
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">kali</span>
                </div>
                @error('periode_pelunasan')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Penjelasan -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-align-left mr-1 text-yellow-400"></i>
                    Penjelasan Detail
                </label>
                <textarea name="penjelasan" rows="4"
                          class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                          placeholder="Jelaskan detail pengajuan kronologi, alasan, dan informasi tambahan lainnya" required>{{ old('penjelasan') }}</textarea>
                @error('penjelasan')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6">
                <a href="{{ route('kronologi.view') }}" class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Ajukan Kronologi
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Card -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-eye mr-2 text-blue-400"></i>
            Preview Pengajuan
        </h3>
        <div class="bg-gray-800/30 rounded-lg p-4">
            <div class="space-y-3">
                <div class="flex items-center">
                    <i class="fas fa-heading text-yellow-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Judul:</span>
                    <span class="text-white" id="preview-judul">-</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-box text-blue-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Barang:</span>
                    <span class="text-white" id="preview-barang">-</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-money-bill-wave text-green-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Harga:</span>
                    <span class="text-green-400 font-semibold" id="preview-harga">Rp 0</span>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-align-left text-purple-400 mr-3 w-5 mt-1"></i>
                    <span class="text-gray-400 mr-2">Penjelasan:</span>
                    <span class="text-white" id="preview-penjelasan">-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Information -->
    <div class="glass-card rounded-2xl p-6 border border-blue-500/30 bg-blue-500/10">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-400 mr-3 mt-1"></i>
            <div>
                <h4 class="text-blue-400 font-semibold mb-2">Informasi Pengajuan</h4>
                <ul class="text-blue-300 text-sm space-y-1">
                    <li>• Pengajuan akan diteruskan ke Kepala Cabang untuk persetujuan pertama</li>
                    <li>• Setelah disetujui Kepala Cabang, pengajuan akan diteruskan ke Admin</li>
                    <li>• Pengajuan harus disetujui oleh kedua pihak untuk dapat diproses</li>
                    <li>• Anda dapat memantau status pengajuan di halaman riwayat</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const judulInput = document.querySelector('input[name="judul"]');
    const barangInput = document.querySelector('input[name="nama_barang"]');
    const hargaInput = document.querySelector('input[name="harga_barang"]');
    const penjelasanInput = document.querySelector('textarea[name="penjelasan"]');

    const previewJudul = document.getElementById('preview-judul');
    const previewBarang = document.getElementById('preview-barang');
    const previewHarga = document.getElementById('preview-harga');
    const previewPenjelasan = document.getElementById('preview-penjelasan');

    judulInput.addEventListener('input', function() {
        previewJudul.textContent = this.value || '-';
    });

    barangInput.addEventListener('input', function() {
        previewBarang.textContent = this.value || '-';
    });

    hargaInput.addEventListener('input', function() {
        const value = parseInt(this.value) || 0;
        previewHarga.textContent = 'Rp ' + value.toLocaleString('id-ID');
    });

    penjelasanInput.addEventListener('input', function() {
        previewPenjelasan.textContent = this.value || '-';
    });
});
</script>
@endsection
