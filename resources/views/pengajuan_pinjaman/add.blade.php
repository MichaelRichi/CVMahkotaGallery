<form method="POST" action="{{ route('pinjaman.add') }}">
    @csrf
    <label>Jumlah Pinjaman</label>
    <input type="number" name="jumlah_pinjaman" required><br>

    <label>Periode Pelunasan (bulan)</label>
    <input type="number" name="periode_pelunasan" required><br>

    <label>Mulai Pelunasan</label>
    <input type="date" name="start_pelunasan" required><br>

    <label>Alasan</label>
    <textarea name="alasan" required></textarea><br>

    <button type="submit">Ajukan</button>
</form>
