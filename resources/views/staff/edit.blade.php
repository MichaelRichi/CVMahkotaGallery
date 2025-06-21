<h2>Edit Staff</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('staff.edit', $staff->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div>
        <label>NIK:</label>
        <input type="text" name="NIK" value="{{ old('NIK', $staff->NIK) }}" required>
    </div>

    <div>
        <label>Nama:</label>
        <input type="text" name="nama" value="{{ old('nama', $staff->nama) }}" required>
    </div>

    <div>
        <label>Jenis Kelamin:</label>
        <select name="JK" required>
            <option value="L" {{ old('JK', $staff->JK) == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('JK', $staff->JK) == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div>
        <label>Tanggal Lahir:</label>
        <input type="date" name="TTL" value="{{ old('TTL', $staff->TTL) }}" required>
    </div>

    <div>
        <label>No Telepon:</label>
        <input type="text" name="notel" value="{{ old('notel', $staff->notel) }}" required>
    </div>

    <div>
        <label>Alamat:</label>
        <textarea name="alamat" required>{{ old('alamat', $staff->alamat) }}</textarea>
    </div>

    <div>
        <label>Tanggal Masuk:</label>
        <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk', $staff->tgl_masuk) }}" required>
    </div>

    <div>
        <label>Tanggal Keluar:</label>
        <input type="date" name="tgl_keluar" value="{{ old('tgl_keluar', $staff->tgl_keluar) }}">
    </div>

    <div>
        <label>Gaji Pokok:</label>
        <input type="number" step="0.01" name="gaji_pokok" value="{{ old('gaji_pokok', $staff->gaji_pokok) }}" required>
    </div>

    <div>
        <label>Gaji Tunjangan:</label>
        <input type="number" step="0.01" name="gaji_tunjangan" value="{{ old('gaji_tunjangan', $staff->gaji_tunjangan) }}" required>
    </div>

    <div>
        <label>Status Aktif:</label>
        <select name="is_active" required>
            <option value="1" {{ old('is_active', $staff->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('is_active', $staff->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>

    <hr>

    <div>
        <label>Cabang Aktif Sekarang:</label>
        <select name="cabang_id_new" id="cabang_select" required>
            @foreach($cabang as $c)
                <option value="{{ $c->id }}" {{ $cabangAktif?->id == $c->id ? 'selected' : '' }}>
                    {{ $c->nama_cabang }}
                </option>
            @endforeach
        </select>
    </div>

    <div id="cabang_dates" style="display: none;">
        <label>Tanggal Selesai Cabang Sebelumnya:</label>
        <input type="date" name="cabang_tgl_selesai">

        <label>Tanggal Mulai Cabang Baru:</label>
        <input type="date" name="cabang_tgl_mulai" value="{{ old('tgl_masuk', date('Y-m-d')) }}">

        <label>Tanggal Selesai Cabang Baru (opsional):</label>
        <input type="date" name="cabang_tgl_selesai_new">
    </div>

    <hr>

    <div>
        <label>Jabatan Aktif Sekarang:</label>
        <select name="jabatan_id_new" id="jabatan_select" required>
            @foreach($jabatan as $j)
                <option value="{{ $j->id }}" {{ $jabatanAktif?->id == $j->id ? 'selected' : '' }}>
                    {{ $j->nama_jabatan }}
                </option>
            @endforeach
        </select>
    </div>

    <div id="jabatan_dates" style="display: none;">
        <label>Tanggal Selesai Jabatan Sebelumnya:</label>
        <input type="date" name="jabatan_tgl_selesai">

        <label>Tanggal Mulai Jabatan Baru:</label>
        <input type="date" name="jabatan_tgl_mulai" value="{{ old('tgl_masuk', date('Y-m-d')) }}">

        <label>Tanggal Selesai Jabatan Baru (opsional):</label>
        <input type="date" name="jabatan_tgl_selesai_new">
    </div>

    <div style="margin-top: 1rem;">
        <button type="submit">Update</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cabangSelect = document.getElementById('cabang_select');
        const jabatanSelect = document.getElementById('jabatan_select');
        const cabangDates = document.getElementById('cabang_dates');
        const jabatanDates = document.getElementById('jabatan_dates');

        const originalCabang = '{{ $cabangAktif?->id }}';
        const originalJabatan = '{{ $jabatanAktif?->id }}';

        cabangSelect.addEventListener('change', function () {
            if (cabangSelect.value !== originalCabang) {
                cabangDates.style.display = 'block';
            } else {
                cabangDates.style.display = 'none';
            }
        });

        jabatanSelect.addEventListener('change', function () {
            if (jabatanSelect.value !== originalJabatan) {
                jabatanDates.style.display = 'block';
            } else {
                jabatanDates.style.display = 'none';
            }
        });

        // Initialize display
        if (cabangSelect.value !== originalCabang) cabangDates.style.display = 'block';
        if (jabatanSelect.value !== originalJabatan) jabatanDates.style.display = 'block';
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ambil elemen jabatan
    const jabatanMulai = document.querySelector('input[name="jabatan_tgl_mulai"]');
    const jabatanSelesaiLama = document.querySelector('input[name="jabatan_tgl_selesai"]');
    const jabatanSelesaiBaru = document.querySelector('input[name="jabatan_tgl_selesai_new"]');

    // ambil elemen cabang
    const cabangMulai = document.querySelector('input[name="cabang_tgl_mulai"]');
    const cabangSelesaiLama = document.querySelector('input[name="cabang_tgl_selesai"]');
    const cabangSelesaiBaru = document.querySelector('input[name="cabang_tgl_selesai_new"]');

    // fungsi batasan untuk jabatan
    function updateJabatanLimits() {
        if (jabatanSelesaiLama && jabatanSelesaiLama.value)
            jabatanMulai.min = jabatanSelesaiLama.value;

        if (jabatanSelesaiBaru && jabatanSelesaiBaru.value)
            jabatanMulai.max = jabatanSelesaiBaru.value;

        if (jabatanMulai && jabatanMulai.value) {
            jabatanSelesaiLama.max = jabatanMulai.value;
            jabatanSelesaiBaru.min = jabatanMulai.value;
        }
    }

    // fungsi batasan untuk cabang
    function updateCabangLimits() {
        if (cabangSelesaiLama && cabangSelesaiLama.value)
            cabangMulai.min = cabangSelesaiLama.value;

        if (cabangSelesaiBaru && cabangSelesaiBaru.value)
            cabangMulai.max = cabangSelesaiBaru.value;

        if (cabangMulai && cabangMulai.value) {
            cabangSelesaiLama.max = cabangMulai.value;
            cabangSelesaiBaru.min = cabangMulai.value;
        }
    }

    // trigger setiap kali input berubah
    [jabatanMulai, jabatanSelesaiLama, jabatanSelesaiBaru].forEach(input => {
        if (input) input.addEventListener('input', updateJabatanLimits);
    });

    [cabangMulai, cabangSelesaiLama, cabangSelesaiBaru].forEach(input => {
        if (input) input.addEventListener('input', updateCabangLimits);
    });

    // jalankan saat load awal
    updateJabatanLimits();
    updateCabangLimits();
});
</script>
