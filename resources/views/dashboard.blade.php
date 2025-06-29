@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Selamat datang di Mahkota Gallery Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="glass-card rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">
                        Selamat Datang, <span class="text-yellow-400">{{ Auth::user()->staff->nama ?? 'User' }}</span>!
                    </h2>
                    <p class="text-gray-400 text-lg">{{ Auth::user()->email }}</p>
                    <div class="mt-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-400/20 text-yellow-400 border border-yellow-400/30">
                            <i class="fas fa-user-tag mr-2"></i>
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div
                        class="w-24 h-24 rounded-full bg-gradient-to-br from-yellow-400/20 to-amber-500/20 flex items-center justify-center border border-yellow-400/30">
                        <i class="fas fa-crown text-4xl text-yellow-400"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-400 text-sm font-medium">Total Staff</p>
                            <p class="text-2xl font-bold text-white mt-1">24</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-400"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-400 text-sm font-medium">Pengajuan Aktif</p>
                            <p class="text-2xl font-bold text-white mt-1">8</p>
                        </div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-green-400"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-400 text-sm font-medium">Cabang Aktif</p>
                            <p class="text-2xl font-bold text-white mt-1">5</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-purple-400"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-400 text-sm font-medium">Cabang Aktif</p>
                            <p class="text-2xl font-bold text-white mt-1">5</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-purple-400"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @if (auth()->user()->role === 'admin')
            <!-- Quick Actions -->
            <div class="glass-card rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-white mb-6">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('pengajuanizin.view') }}"
                        class="group bg-gradient-to-br from-yellow-500/10 to-amber-500/10 border border-yellow-500/20 rounded-xl p-6 hover:from-yellow-500/20 hover:to-amber-500/20 transition-all duration-300 hover:scale-105">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-yellow-500/30 transition-colors">
                                <i class="fas fa-plus-circle text-2xl text-yellow-400"></i>
                            </div>
                            <h4 class="text-white font-semibold mb-2">Pengajuan Izin</h4>
                            <p class="text-gray-400 text-sm">Lihat pengajuan izin baru</p>
                        </div>
                    </a>

                    <a href="{{ route('kronologi.view') }}"
                        class="group bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6 hover:from-blue-500/20 hover:to-blue-600/20 transition-all duration-300 hover:scale-105">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-500/30 transition-colors">
                                <i class="fas fa-plus-square text-2xl text-blue-400"></i>
                            </div>
                            <h4 class="text-white font-semibold mb-2">Pengajuan Kronologi</h4>
                            <p class="text-gray-400 text-sm">Lihat pengajuan kronologi</p>
                        </div>
                    </a>

                    <a href="{{ route('pengajuanizin.riwayat') }}"
                        class="group bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6 hover:from-green-500/20 hover:to-green-600/20 transition-all duration-300 hover:scale-105">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-green-500/30 transition-colors">
                                <i class="fas fa-history text-2xl text-green-400"></i>
                            </div>
                            <h4 class="text-white font-semibold mb-2">Riwayat Izin</h4>
                            <p class="text-gray-400 text-sm">Lihat riwayat pengajuan</p>
                        </div>
                    </a>

                    <a href="{{ route('staff.view') }}"
                        class="group bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6 hover:from-purple-500/20 hover:to-purple-600/20 transition-all duration-300 hover:scale-105">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-purple-500/30 transition-colors">
                                <i class="fas fa-users text-2xl text-purple-400"></i>
                            </div>
                            <h4 class="text-white font-semibold mb-2">Data Staff</h4>
                            <p class="text-gray-400 text-sm">Kelola data karyawan</p>
                        </div>
                    </a>
                </div>
            </div>
        @endif

        <!-- Recent Activity -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">Recent Activity</h3>
            <div class="space-y-4">
                <div class="flex items-center p-4 bg-gray-800/30 rounded-lg border border-gray-700/50">
                    <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-check text-green-400"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Pengajuan izin disetujui</p>
                        <p class="text-gray-400 text-sm">2 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-gray-800/30 rounded-lg border border-gray-700/50">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-plus text-blue-400"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Pengajuan kronologi baru</p>
                        <p class="text-gray-400 text-sm">5 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-gray-800/30 rounded-lg border border-gray-700/50">
                    <div class="w-10 h-10 bg-yellow-500/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-plus text-yellow-400"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Staff baru ditambahkan</p>
                        <p class="text-gray-400 text-sm">1 hari yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
