<form action="{{ route('jabatan.edit', $jabatan->id) }}" method="POST">
    @csrf
    @method('PATCH')


    <div class="form-group">
        <label>Nama Jabatan</label>
        <input type="text" name="nama_jabatan" class="form-control" value="{{ $jabatan ->nama_jabatan }}" required>
        @error('nama_jabatan')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Status Aktif</label>
        <select name="is_active" class="form-control" required>
            <option value="1" {{ $jabatan->is_active == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $jabatan->is_active == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('jabatan.view') }}" class="btn btn-secondary">Batal</a>
</form>