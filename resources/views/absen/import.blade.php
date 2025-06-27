<div class="container">
    <h3>Import Data Absen Bulanan</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('absen.import.proses') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Bulan</label>
            <input type="month" name="bulan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>File Excel</label>
            <input type="file" name="file" class="form-control" required accept=".xlsx,.xls">
        </div>

        <button class="btn btn-primary">Import</button>
        <a href="{{ route('absen.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
