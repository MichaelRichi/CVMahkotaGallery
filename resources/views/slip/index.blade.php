<h2>Daftar Penggajian</h2>

<a href="{{ route('slip.preview') }}" class="btn btn-primary">+ Lakukan Penggajian Baru</a>

<table>
    <thead>
        <tr>
            <th>Periode</th>
            <th>Cabang</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($slipGroup as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->periode)->format('F Y') }}</td>
                <td>{{ $item->cabang->nama_cabang ?? '-' }}</td>
                <td>
                    <a href="{{ route('slip.periode.detail', ['periode' => $item->periode, 'cabang_id' => $item->cabang_id]) }}">
                        Lihat Slip
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
