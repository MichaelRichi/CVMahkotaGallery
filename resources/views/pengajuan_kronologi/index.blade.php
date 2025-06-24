<form method="GET" action="{{ route('kronologi.index') }}">
    <select name="status" onchange="this.form.submit()">
        <option value="semua" {{ $filter == 'semua' ? 'selected' : '' }}>Semua</option>
        <option value="menunggu" {{ $filter == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
        <option value="diterima" {{ $filter == 'diterima' ? 'selected' : '' }}>Diterima</option>
        <option value="ditolak" {{ $filter == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
</form>
<a href="kronologi/addView">tambah</a>
<table class="table">
    <thead>
        <tr>
            <th>Nama Staff</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengajuan as $item)
        <tr>
            <td>{{ $item->staff->nama }}</td>
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