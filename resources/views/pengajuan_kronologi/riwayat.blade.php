<h2>Riwayat Pengajuan Kronologi</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengajuan as $item)
        <tr>
            <td>{{ $item->judul }}</td>
            <td>
                @if (is_null($item->validasi_admin) || is_null($item->validasi_kepalacabang))
                    <span class="badge bg-warning">Menunggu</span>
                @elseif ($item->validasi_admin === 0 || $item->validasi_kepalacabang === 0)
                    <span class="badge bg-danger">Ditolak</span>
                @else
                    <span class="badge bg-success">Diterima</span>
                @endif
            </td>
            <td><a href="{{ route('kronologi.detail', $item->id) }}" class="btn btn-primary btn-sm">Lihat</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
