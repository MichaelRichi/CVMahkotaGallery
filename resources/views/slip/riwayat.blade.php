<h2>Riwayat Slip Gaji</h2>
<table>
    <tr>
        <th>Nama</th>
        <th>Periode</th>
        <th>Gaji Bersih</th>
        <th>Aksi</th>
    </tr>
    @foreach($data as $slip)
    <tr>
        <td>{{ $slip->staff->nama ?? 'Anda' }}</td>
        <td>{{ \Carbon\Carbon::parse($slip->periode)->format('F Y') }}</td>
        <td>{{ number_format($slip->gaji_bersih) }}</td>
        <td><a href="{{ route('slip.detail', $slip->id) }}">Lihat</a></td>
    </tr>
    @endforeach
</table>
