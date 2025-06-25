<table>
    <tr>
        <th>Nama</th><th>Jumlah</th><th>Periode</th><th>Mulai</th><th>Status</th><th>Aksi</th>
    </tr>
    @foreach ($data as $p)
    <tr>
        <td>{{ $p->staff->nama ?? 'Anda' }}</td>
        <td>{{ number_format($p->jumlah_pinjaman) }}</td>
        <td>{{ $p->periode_pelunasan }} bulan</td>
        <td>{{ $p->start_pelunasan }}</td>
        <td>
            @if(is_null($p->validasi_admin)) Menunggu
            @elseif($p->validasi_admin) Diterima
            @else Ditolak
            @endif
        </td>
        <td>
            @if(Auth::user()->role === 'admin' && is_null($p->validasi_admin))
            <form action="{{ route('pinjaman.validasi', $p->id) }}" method="POST">
                @csrf
                <button name="aksi" value="terima">✔</button>
                <button name="aksi" value="tolak">✘</button>
            </form>
            @endif
        </td>
    </tr>
    @endforeach
</table>
