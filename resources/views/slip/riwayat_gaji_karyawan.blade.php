@extends('layouts.app')

@section('title', 'Riwayat Penggajian Saya')
@section('page-title', 'Riwayat Penggajian Saya')
@section('page-description', 'Lihat riwayat penggajian pribadi Anda')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Riwayat Penggajian Saya</h2>
                    <p class="text-gray-400">Pantau riwayat penggajian Anda per {{ now()->format('F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-filter mr-2 text-yellow-400"></i>
                Filter Riwayat
            </h3>

            <form method="GET" action="{{ route('slip.karyawan.riwayat') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Month Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Bulan</label>
                    <select name="month" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                        <option value="">-- Semua Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Year Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tahun</label>
                    <select name="year" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                        <option value="">-- Semua Tahun --</option>
                        @for ($i = 2020; $i <= now()->year; $i++)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </form>
        </div>

        <!-- Salary History Table -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-800/50 border-b border-gray-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2 text-yellow-400"></i>
                                Periode
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
                                Gaji Pokok
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-hand-holding-usd mr-2 text-yellow-400"></i>
                                Tunjangan
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                Pot. Kronologi
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                Pot. Peminjaman
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                Pot. Izin
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-wallet mr-2 text-yellow-400"></i>
                                Gaji Bersih
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-clock mr-2 text-yellow-400"></i>
                                Tanggal Penggajian
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($payrolls as $payroll)
                            <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <span class="text-white">{{ \Carbon\Carbon::parse($payroll->periode)->format('F Y') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-white font-medium">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-white font-medium">Rp {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-red-400 font-medium">Rp {{ number_format($payroll->potongan_kronologi, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-red-400 font-medium">Rp {{ number_format($payroll->potongan_hutang, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-red-400 font-medium">Rp {{ number_format($payroll->potongan_izin, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-white font-medium">Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-300">{{ $payroll->tanggal_penggajian->format('Y-m-d H:i') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-history text-4xl text-gray-600 mb-4"></i>
                                        <p class="text-gray-400 text-lg">Tidak ada riwayat penggajian</p>
                                        <p class="text-gray-500 text-sm">Silakan hubungi HRD jika ada masalah</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
