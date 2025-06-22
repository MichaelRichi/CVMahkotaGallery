<form action="{{ route('cabang.add') }}" method="POST">
    @csrf

    <label>Nama Cabang:</label><br>
    <input type="text" name="nama_cabang" value="{{ old('nama_cabang') }}">
    @error('nama_cabang')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <br><br>
    

    <label>Alamat:</label><br>
    <input type="text" name="alamat" value="{{ old('alamat') }}">
    @error('alamat')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <br><br>

    <label>Jam Masuk:</label><br>
    <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}">
    @error('jam_masuk')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <br><br>

    <label>Jam Pulang:</label><br>
    <input type="time" name="jam_pulang" value="{{ old('jam_pulang') }}">
    @error('jam_pulang')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <br><br>

    <label>Status Aktif:</label><br>
    <select name="is_active">
        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
    </select>
    @error('is_active')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <br><br>

    <button type="submit">Simpan</button>
</form>