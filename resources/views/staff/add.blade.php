<h2>Tambah Staff</h2>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('staff.add') }}" method="POST">
    @csrf

    <div>
        <label>NIK:</label>
        <input type="text" name="NIK" value="{{ old('NIK') }}" required>
    </div>

    <div>
        <label>Nama:</label>
        <input type="text" name="nama" value="{{ old('nama') }}" required>
    </div>

    <div>
        <label>Jenis Kelamin:</label>
        <select name="JK" required>
            <option value="">-- Pilih --</option>
            <option value="L" {{ old('JK') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('JK') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div>
        <label>Tanggal Lahir:</label>
        <input type="date" name="TTL" value="{{ old('TTL') }}" required>
    </div>

    <div>
        <label>No Telepon:</label>
        <input type="text" name="notel" value="{{ old('notel') }}" required>
    </div>

    <div>
        <label>Alamat:</label>
        <textarea name="alamat" required>{{ old('alamat') }}</textarea>
    </div>

    <div>
        <label>Tanggal Masuk:</label>
        <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk') }}" required>
    </div>

    <div>
        <label>Tanggal Keluar:</label>
        <input type="date" name="tgl_keluar" value="{{ old('tgl_keluar') }}">
    </div>

    <div>
        <label>Gaji Pokok:</label>
        <input type="number" step="0.01" name="gaji_pokok" value="{{ old('gaji_pokok') }}" required>
    </div>

    <div>
        <label>Gaji Tunjangan:</label>
        <input type="number" step="0.01" name="gaji_tunjangan" value="{{ old('gaji_tunjangan') }}" required>
    </div>

    <div>
        <label>Status Aktif:</label>
        <select name="is_active" required>
            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>

    <div>
        <label>Cabang Aktif:</label>
        <select name="cabang_id" required>
            <option value="">-- Pilih Cabang --</option>
            @foreach ($cabang as $c)
                <option value="{{ $c->id }}" {{ old('cabang_id') == $c->id ? 'selected' : '' }}>
                    {{ $c->nama_cabang }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Jabatan Aktif:</label>
        <select name="jabatan_id" required>
            <option value="">-- Pilih Jabatan --</option>
            @foreach ($jabatan as $j)
                <option value="{{ $j->id }}" {{ old('jabatan_id') == $j->id ? 'selected' : '' }}>
                    {{ $j->nama_jabatan }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-top: 1rem;">
        <button type="submit">Simpan</button>
    </div>
</form>