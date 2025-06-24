<h2>Form Pengajuan Kronologi</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('kronologi.add') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Judul:</label>
        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
        @error('judul')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
        @error('nama_barang')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Penjelasan:</label>
        <textarea name="penjelasan" class="form-control">{{ old('penjelasan') }}</textarea>
        @error('penjelasan')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Harga Barang:</label>
        <input type="number" name="harga_barang" class="form-control" min="0" value="{{ old('harga_barang') }}">
        @error('harga_barang')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-primary">Ajukan</button>
</form>
