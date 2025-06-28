<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex gap-2 align-items-center">
            <label for="bulan">Bulan:</label>
            <input type="month" name="bulan" id="bulan" value="{{ $bulan }}" class="form-control">
            <button class="btn btn-primary btn-sm">Tampilkan</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($absen as $a)
                    <tr>
                        <td class="text-center">{{ $a->tanggal->format('d F Y') }}</td>
                        <td class="text-center">
                            @php
                                $label = [
                                    'H' => 'Hadir',
                                    'T' => 'Telat',
                                    'A' => 'Alpa',
                                    'I' => 'Izin',
                                    'S' => 'Sakit',
                                    'O' => 'Off',
                                    'C' => 'Cuti',
                                ];
                            @endphp
                            <span class="badge bg-secondary">{{ $label[$a->status] ?? $a->status }}</span>
                        </td>
                        <td>{{ $a->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data absen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>