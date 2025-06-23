<form action="{{ route('jabatan.add') }}" method="POST">
    @csrf

    <label>Nama Jabatan:</label><br>
    <input type="text" name="nama_jabatan" value="{{ old('nama_jabatan') }}">
    @error('nama_jabatan')
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