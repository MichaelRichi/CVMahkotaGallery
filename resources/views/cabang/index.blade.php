<form method="GET" action="{{ route('cabang.view') }}">
    <div>
        <label for="filter" class="form-label mb-0 fw-medium">Filter:</label>
        <select name="filter" id="filter" onchange="this.form.submit()" class="form-select" >
            <option value="aktif" {{ (isset($filter) && $filter === 'aktif') ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ (isset($filter) && $filter === 'nonaktif') ? 'selected' : '' }}>Tidak Aktif</option>
            <option value="semua" {{ (isset($filter) && $filter === 'semua') ? 'selected' : '' }}>Semua</option>
        </select>
    </div>
</form>
<a href="{{ route('cabang.addView') }}">tambah cabang</a>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<table>
    <thead>
        <tr>
            <th>cabang</th>
            <th>jam masuk</th>
            <th>jam pulang</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($dataCabang as $index => $cabang)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $cabang->nama_cabang }}</td>
                <td class="text-center">{{ $cabang->jam_masuk }}</td>
                <td class="text-center">{{ $cabang->jam_pulang }}</td>
                <td class="text-center">{{ $cabang->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                <td></td>
            </tr>
        @empty
            <tr><td colspan="5">Tidak ada data cabang.</td></tr>
        @endforelse
    </tbody>
</table>