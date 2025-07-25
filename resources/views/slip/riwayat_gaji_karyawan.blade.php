@extends('layouts.app')

   @section('title', 'Riwayat Penggajian Saya')
   @section('page-title', 'Riwayat Penggajian Saya')
   @section('page-description', 'Lihat riwayat penggajian pribadi Anda')

   @section('content')
       <style>
           /* PDF-specific styles */
           @media print {
               .glass-card {
                   background: none;
                   border: 1px solid #ddd;
                   box-shadow: none;
               }
               .bg-gradient-to-r {
                   background: none !important;
                   color: #000 !important;
                   border: 1px solid #000;
               }
               .text-white { color: #000 !important; }
               .text-gray-300, text-gray-400, .text-gray-500 { color: #333 !important; }
               .text-yellow-400 { color: #000 !important; }
               .text-red-400 { color: #000 !important; }
               .bg-blue-600, .hover\:bg-blue-700:hover { background: none !important; border: 1px solid #000; color: #000 !important; }
               .bg-green-500, .hover\:bg-green-600:hover, .bg-green-600, .hover\:bg-green-700:hover { background: none !important; border: 1px solid #000; color: #000 !important; }
               .hover\:bg-gray-800\/30:hover { background: none !important; }
               .transform, .hover\:scale-105:hover { transform: none !important; }
               table { width: 100%; border-collapse: collapse; }
               th, td { border: 1px solid #000; padding: 8px; }
               th { background-color: #f2f2f2; }
               .text-right { text-align: right; }
               .text-center { text-align: center; }
               .hidden-in-pdf { display: none !important; }
           }
       </style>

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
                               <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                   <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
                                   Gaji Pokok
                               </th>
                               <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                   <i class="fas fa-hand-holding-usd mr-2 text-yellow-400"></i>
                                   Tunjangan
                               </th>
                               <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                   <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                   Pot. Denda
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
                                   <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                   Pot. Alpha
                               </th>
                               <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                   <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                   Pot. Terlambat
                               </th>
                               <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                   <i class="fas fa-wallet mr-2 text-yellow-400"></i>
                                   Gaji Bersih
                               </th>
                               <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                   <i class="fas fa-eye mr-2 text-yellow-400"></i>
                                   Aksi
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
                                       <span class="text-red-400 font-medium">Rp {{ number_format($payroll->potongan_alpha, 0, ',', '.') }}</span>
                                   </td>
                                   <td class="px-6 py-4 text-right">
                                       <span class="text-red-400 font-medium">Rp {{ number_format($payroll->potongan_terlambat, 0, ',', '.') }}</span>
                                   </td>
                                   <td class="px-6 py-4 text-right">
                                       <span class="text-white font-medium">Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</span>
                                   </td>
                                   <td class="px-6 py-4 hidden-in-pdf">
                                       <div class="flex space-x-2">
                                           <a href="{{ route('slip.karyawan.detail', $payroll->id) }}"
                                              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                               <i class="fas fa-eye mr-2"></i> Detail
                                           </a>
                                           <a href="{{ route('slip.riwayat.karyawan.pdf', $payroll->id) }}"
                                              class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                               <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
                                           </a>
                                       </div>
                                   </td>
                               </tr>
                           @empty
                               <tr>
                                   <td colspan="10" class="px-6 py-12 text-center">
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
