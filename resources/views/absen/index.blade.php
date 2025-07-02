@extends('layouts.app')

@section('title', 'Rekap Absen')
@section('page-title', 'Rekap Absen')
@section('page-description', 'Pantau kehadiran karyawan dengan mudah dan akurat')

@section('content')
    <div class="space-y-6">
        <!-- Header Card -->
        <div class="glass-card rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-white"></i> Rekap Absen Bulan <span
                            class="text-yellow-400">{{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</span>
                    </h2>
                    <p class="text-gray-400 text-lg">Pantau kehadiran karyawan dengan mudah dan akurat</p>
                </div>
                <div class="hidden md:block">
                    <a href="{{ route('absen.import.form') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                        <i class="fas fa-upload mr-2"></i>
                        Import Excel
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-400 text-sm font-medium">Total Karyawan</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ count($staffList) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-400"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-400 text-sm font-medium">Hari Kerja</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $jumlahHari }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-400 text-sm font-medium">Cabang</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $cabangId ? 1 : count($cabangList) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-purple-400"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-yellow-500/10 to-amber-500/10 border border-yellow-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-400 text-sm font-medium">Periode</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ \Carbon\Carbon::parse($bulan)->format('m/Y') }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-yellow-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">🔍 Filter Data Absen</h3>
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Pilih Cabang</label>
                    <select name="cabang_id"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Semua Cabang</option>
                        @foreach ($cabangList as $cabang)
                            <option value="{{ $cabang->id }}" {{ $cabangId == $cabang->id ? 'selected' : '' }}>
                                {{ $cabang->nama_cabang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Pilih Bulan</label>
                    <input type="month" name="bulan" value="{{ $bulan }}"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-lg hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                        <i class="fas fa-search mr-2"></i>
                        Filter Data
                    </button>
                </div>

                <div class="flex items-end">
                    <button type="button" onclick="window.print()"
                        class="w-full px-6 py-3 bg-gray-700 text-white font-medium rounded-lg hover:bg-gray-600 transition-all duration-300">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                </div>
            </form>
        </div>

        <!-- Attendance Table -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">📊 Tabel Kehadiran Karyawan</h3>

            @if (count($staffList) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <
                        <thead class="bg-gray-800/30 rounded-lg">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider sticky left-0 bg-gray-800 min-w-[200px] rounded-l-lg">
                                    Nama Karyawan
                                </th>
                                @for ($i = 1; $i <= $jumlahHari; $i++)
                                    <th
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider min-w-[40px]">
                                        {{ $i }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="space-y-2">
                            @foreach ($staffList as $staff)
                                <tr
                                    class="bg-gray-800/30 rounded-lg border border-gray-700/50 hover:bg-gray-800/50 transition-colors duration-200">
                                    <td
                                        class="px-4 py-4 whitespace-nowrap sticky left-0 bg-gray-800 rounded-l-lg">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-blue-400"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-white">{{ $staff->nama }}</div>
                                                <div class="text-xs text-gray-400">ID: {{ $staff->absen_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    @for ($i = 1; $i <= $jumlahHari; $i++)
                                        <td class="px-3 py-4 text-center">
                                            @php
                                                $data = $absenData[$staff->id][$i][0] ?? null;
                                                $status = $data ? $data->status : '-';
                                            @endphp

                                            @if ($status !== '-')
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold
                                                @if ($status === 'H') bg-green-500/20 text-green-400 border border-green-500/30
                                                @elseif($status === 'S') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                                @elseif($status === 'I') bg-blue-500/20 text-blue-400 border border-blue-500/30
                                                @elseif($status === 'A') bg-red-500/20 text-red-400 border border-red-500/30
                                                @elseif($status === 'T') bg-purple-500/20 text-purple-400 border border-purple-500/30
                                                @elseif($status === 'L') bg-orange-500/20 text-orange-400 border border-orange-500/30
                                                @else bg-gray-500/20 text-gray-400 border border-gray-500/30 @endif">
                                                    {{ $status }}
                                                </span>
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Legend -->
                <div class="mt-8 p-6 bg-gray-800/30 rounded-lg border border-gray-700/50">
                    <h4 class="text-lg font-semibold text-white mb-4">📖 Keterangan Status</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-green-500/20 text-green-400 border border-green-500/30">H</span>
                            <span class="text-white text-sm">Hadir</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">S</span>
                            <span class="text-white text-sm">Sakit</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400 border border-blue-500/30">I</span>
                            <span class="text-white text-sm">Izin</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-red-500/20 text-red-400 border border-red-500/30">A</span>
                            <span class="text-white text-sm">Alpha</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-purple-500/20 text-purple-400 border border-purple-500/30">T</span>
                            <span class="text-white text-sm">Terlambat</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-orange-500/20 text-orange-400 border border-orange-500/30">L</span>
                            <span class="text-white text-sm">Libur</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-gray-500/20 text-gray-400 border border-gray-500/30">-</span>
                            <span class="text-white text-sm">Tidak Ada Data</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-yellow-400"></i>
                    </div>
                    <h4 class="text-xl font-semibold text-white mb-2">Tidak Ada Data Karyawan</h4>
                    <p class="text-gray-400 mb-6">Silakan pilih cabang dan periode yang berbeda atau import data absen</p>
                    <a href="{{ route('absen.import.form') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                        <i class="fas fa-upload mr-2"></i>
                        Import Data Absen
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .glass-card,
            .glass-card * {
                visibility: visible;
            }

            .glass-card {
                position: absolute;
                left: 0;
                top: 0;
                background: white !important;
                color: black !important;
            }
        }

        input[type="month"]::-webkit-calendar-picker-indicator {
            filter: invert(100%);
        }
    </style>
@endsection
