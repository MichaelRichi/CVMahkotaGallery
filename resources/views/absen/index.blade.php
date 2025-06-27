<div class="container">
    <h3>Rekap Absen Bulan {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</h3>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <select name="cabang_id" class="form-control">
                <option value="">Semua Cabang</option>
                @foreach($cabangList as $cabang)
                    <option value="{{ $cabang->id }}" {{ $cabangId == $cabang->id ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="month" name="bulan" class="form-control" value="{{ $bulan }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
        </div>
        <div class="col-md-2 text-end">
            <a href="{{ route('absen.import.form') }}" class="btn btn-success">Import Excel</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered small text-center">
            <thead>
                <tr>
                    <th>Nama</th>
                    @for ($i = 1; $i <= $jumlahHari; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach($staffList as $staff)
                    <tr>
                        <td class="text-start">{{ $staff->absen_id }}</td>
                        @for ($i = 1; $i <= $jumlahHari; $i++)
                            <td>
                                @php
                                    $data = $absenData[$staff->id][$i][0] ?? null;
                                    echo $data ? $data->status : '-';
                                @endphp
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>