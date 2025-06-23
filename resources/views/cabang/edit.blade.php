<form action="{{ route('cabang.edit', $cabang->id) }}" method="POST">
    @csrf
    @method('PATCH')


    <div class="form-group">
        <label>Nama Cabang</label>
        <input type="text" name="nama_cabang" class="form-control" value="{{ $cabang->nama_cabang }}" required>
        @error('nama_cabang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <input type="text" name='alamat' class='form-control' value='{{ $cabang->alamat }}'>
        @error('alamat')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Jam Masuk:</label>
        <input type="time" name="jam_masuk" value="{{ \Carbon\Carbon::parse($cabang->jam_masuk)->format('H:i') }}">
        @error('jam_masuk')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Jam Pulang:</label>
        <input type="time" name="jam_pulang" value="{{ \Carbon\Carbon::parse($cabang->jam_pulang)->format('H:i') }}">
        @error('jam_pulang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Status Aktif</label>
        <select name="is_active" class="form-control" required>
            <option value="1" {{ $cabang->is_active == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $cabang->is_active == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('cabang.view') }}" class="btn btn-secondary">Batal</a>
</form>