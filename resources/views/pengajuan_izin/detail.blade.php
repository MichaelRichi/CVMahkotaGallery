
<div class="container">
    <h2>Detail Pengajuan Izin</h2>

    <a href="{{ route('pengajuanizin.view') }}" class="btn btn-secondary btn-sm mb-3">← Kembali</a>

    <table class="table table-bordered">
        <tr>
            <th>Nama Staff</th>
            <td>{{ $pengajuan->staff->nama }}</td>
        </tr>
        <tr>
            <th>Status Validasi</th>
            <td>
                @if(is_null($pengajuan->validasi_admin))
                    <span class="text-warning">Menunggu</span>
                @elseif($pengajuan->validasi_admin == 0)
                    <span class="text-danger">Ditolak</span>
                @else
                    <span class="text-success">Diterima</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Divalidasi Oleh</th>
            <td>{{ $pengajuan->admin->nama ?? '-' }}</td>
        </tr>
    </table>

    <h4>Detail Hari Izin</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuan->detail_pengajuan_izin->sortBy('tanggal') as $detail)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($detail->tanggal)->format('d M Y') }}</td>
                    <td>{{ ucfirst($detail->status) }}</td>
                    <td>{{ $detail->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if(auth()->user()->role === 'admin' && is_null($pengajuan->validasi_admin))
    <div class="mt-4">
        <form action="{{ route('pengajuanizin.validasi', $pengajuan->id) }}" method="POST" style="display: inline-block;">
            @csrf
            <input type="hidden" name="aksi" value="terima">
            <button class="btn btn-success" onclick="return confirm('Yakin ingin menerima pengajuan ini?')">✔ Terima</button>
        </form>

        <form action="{{ route('pengajuanizin.validasi', $pengajuan->id) }}" method="POST" style="display: inline-block;">
            @csrf
            <input type="hidden" name="aksi" value="tolak">
            <button class="btn btn-danger" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">✖ Tolak</button>
        </form>
    </div>
@endif
