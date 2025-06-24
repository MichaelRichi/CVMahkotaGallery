<div class="container">
    <h3>Riwayat Pengajuan Izin Saya</h3>
    <li><a href="{{ route('pengajuanizin.addView') }}">ajukan izin</a></li>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Jumlah Hari</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuan as $izin)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $izin->detail_pengajuan_izin->count() }} hari</td>
                    <td>
                        @if(is_null($izin->validasi_admin))
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($izin->validasi_admin)
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td><a href="{{ route('pengajuanizin.detail', $izin->id) }}" class="btn btn-sm btn-primary">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada pengajuan izin</td></tr>
            @endforelse
        </tbody>
    </table>
</div>