<h2>Detail Pengajuan</h2>
<p>Nama: {{ $pengajuan->staff->nama }}</p>
<p>Judul: {{ $pengajuan->judul }}</p>
<p>Nama Barang: {{ $pengajuan->nama_barang }}</p>
<p>Penjelasan: {{ $pengajuan->penjelasan }}</p>
<p>Harga: Rp{{ number_format($pengajuan->harga_barang) }}</p>
<p>Status Kepala Cabang: {{ $pengajuan->validasi_kepalacabang === null ? 'Menunggu' : ($pengajuan->validasi_kepalacabang ? 'Disetujui' : 'Ditolak') }}</p>
<p>Status Admin: {{ $pengajuan->validasi_admin === null ? 'Menunggu' : ($pengajuan->validasi_admin ? 'Disetujui' : 'Ditolak') }}</p>

@if(Auth::user()->role === 'admin')
    @if($pengajuan->validasi_admin === null)
        <form action="{{ route('kronologi.validasi', $pengajuan->id) }}" method="POST">
            @csrf
            <button name="aksi" value="terima" class="btn btn-success" {{ $pengajuan->validasi_kepalacabang === 1 ? '' : 'disabled' }}>Terima</button>
            <button name="aksi" value="tolak" class="btn btn-danger" {{ $pengajuan->validasi_kepalacabang === 1 ? '' : 'disabled' }}>Tolak</button>
        </form>
        @if($pengajuan->validasi_kepalacabang !== 1)
            <small class="text-muted">Menunggu persetujuan kepala cabang terlebih dahulu.</small>
        @endif
    @endif
@endif

@if(Auth::user()->role === 'kepala' && $pengajuan->validasi_kepalacabang === null)
    <form action="{{ route('kronologi.validasi', $pengajuan->id) }}" method="POST">
        @csrf
        <button name="aksi" value="terima" class="btn btn-success">Terima</button>
        <button name="aksi" value="tolak" class="btn btn-danger">Tolak</button>
    </form>
@endif


