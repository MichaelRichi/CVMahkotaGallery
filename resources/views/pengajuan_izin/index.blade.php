<h2>Daftar Pengajuan Izin</h2>

<form method="GET" action="{{ route('pengajuanizin.view') }}">
    <label>Filter Status:</label>
    <select name="filter" onchange="this.form.submit()">
        <option value="semua" {{ $filter == 'semua' ? 'selected' : '' }}>Semua</option>
        <option value="menunggu" {{ $filter == 'menunggu' ? 'selected' : '' }}>Menunggu ACC</option>
        <option value="acc" {{ $filter == 'acc' ? 'selected' : '' }}>Di-ACC</option>
        <option value="ditolak" {{ $filter == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
</form>

<br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Nama Staff</th>
            <th>Tanggal Pengajuan</th>
            <th>Status Validasi</th>
            <th>Admin Validasi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($dataPengajuan as $izin)
            <tr>
                <td>{{ $izin->staff->nama }}</td>
                <td>{{ $izin->created_at->format('d-m-Y') }}</td>
                <td>
                    @if (is_null($izin->validasi_admin))
                        <span style="color: orange;">Menunggu</span>
                    @elseif ($izin->validasi_admin == 1)
                        <span style="color: green;">Di-ACC</span>
                    @else
                        <span style="color: red;">Ditolak</span>
                    @endif
                </td>
                <td>{{ $izin->admin->nama ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" align="center">Tidak ada data pengajuan</td>
            </tr>
        @endforelse
    </tbody>
</table>