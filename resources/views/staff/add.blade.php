@extends('layouts.app')

@section('title', 'Tambah Staff')
@section('page-title', 'Tambah Staff')
@section('page-description', 'Tambah karyawan baru ke sistem')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Tambah Staff Baru</h2>
                <p class="text-gray-400">Lengkapi form di bawah untuk menambah karyawan baru</p>
            </div>
            <a href="{{ route('staff.view') }}" class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="glass-card rounded-2xl p-6 border border-red-500/30 bg-red-500/10">
            <div class="flex items-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                <h3 class="text-red-400 font-semibold">Terdapat kesalahan:</h3>
            </div>
            <ul class="space-y-2">
                @foreach ($errors->all() as $err)
                    <li class="text-red-300 text-sm flex items-center">
                        <i class="fas fa-dot-circle mr-2 text-xs"></i>
                        {{ $err }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('staff.add') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Personal Information -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-user mr-2 text-yellow-400"></i>
                Informasi Personal
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-id-card mr-1 text-yellow-400"></i>
                        NIK
                    </label>
                    <input type="text" name="NIK" value="{{ old('NIK') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Masukkan NIK" required>
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-user mr-1 text-yellow-400"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-venus-mars mr-1 text-yellow-400"></i>
                        Jenis Kelamin
                    </label>
                    <select name="JK" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('JK') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('JK') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-calendar mr-1 text-yellow-400"></i>
                        Tanggal Lahir
                    </label>
                    <input type="date" name="TTL" value="{{ old('TTL') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                </div>

                <!-- No Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-phone mr-1 text-yellow-400"></i>
                        No Telepon
                    </label>
                    <input type="text" name="notel" value="{{ old('notel') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Masukkan nomor telepon" required>
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt mr-1 text-yellow-400"></i>
                        Alamat
                    </label>
                    <textarea name="alamat" rows="3"
                              class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                              placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Employment Information -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-briefcase mr-2 text-yellow-400"></i>
                Informasi Pekerjaan
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal Masuk -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-calendar-plus mr-1 text-yellow-400"></i>
                        Tanggal Masuk
                    </label>
                    <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                </div>

                <!-- Tanggal Keluar -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-calendar-minus mr-1 text-yellow-400"></i>
                        Tanggal Keluar (Opsional)
                    </label>
                    <input type="date" name="tgl_keluar" value="{{ old('tgl_keluar') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                </div>

                <!-- Cabang -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-building mr-1 text-yellow-400"></i>
                        Cabang
                    </label>
                    <select name="cabang_id" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                        <option value="">-- Pilih Cabang --</option>
                        @foreach ($cabang as $c)
                            <option value="{{ $c->id }}" {{ old('cabang_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->nama_cabang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-user-tie mr-1 text-yellow-400"></i>
                        Jabatan
                    </label>
                    <select name="jabatan_id" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('jabatan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-toggle-on mr-1 text-yellow-400"></i>
                        Status
                    </label>
                    <select name="is_active" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Salary Information -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
                Informasi Gaji
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Gaji Pokok -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-coins mr-1 text-yellow-400"></i>
                        Gaji Pokok
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                        <input type="number" step="0.01" name="gaji_pokok" value="{{ old('gaji_pokok') }}"
                               class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                               placeholder="0" required>
                    </div>
                </div>

                <!-- Gaji Tunjangan -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-hand-holding-usd mr-1 text-yellow-400"></i>
                        Gaji Tunjangan
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                        <input type="number" step="0.01" name="gaji_tunjangan" value="{{ old('gaji_tunjangan') }}"
                               class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                               placeholder="0" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('staff.view') }}" class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Staff
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

