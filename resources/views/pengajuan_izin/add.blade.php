<div class="container">
    <h2>Form Tambah Pengajuan Izin (Multi Detail)</h2>

    @if ($errors->any())
        <div class="text-danger">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pengajuanizin.add') }}">
        @csrf

        <div id="detail-container">
            <label>Detail Izin:</label>
            <div class="row detail-row mb-2">
                <div class="col-md-3">
                    <input type="date" name="detail[0][tanggal]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <select name="detail[0][status]" class="form-control" required>
                        <option value="">Pilih Status</option>
                        <option value="I">Izin</option>
                        <option value="S">Sakit</option>
                        <option value="C">Cuti</option>
                        <option value="O">Off</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="detail[0][keterangan]" class="form-control" placeholder="Keterangan">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm btn-remove">🗑️</button>
                </div>
            </div>
        </div>

        <button type="button" id="btn-add" class="btn btn-primary btn-sm mb-3">➕ Tambah Baris</button><br>
        <button type="submit" class="btn btn-success">Ajukan Izin</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('detail-container');
        const btnAdd = document.getElementById('btn-add');
        let index = 1;

        btnAdd.addEventListener('click', () => {
            const row = document.createElement('div');
            row.classList.add('row', 'detail-row', 'mb-2');

            row.innerHTML = `
                <div class="col-md-3">
                    <input type="date" name="detail[${index}][tanggal]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <select name="detail[${index}][status]" class="form-control" required>
                        <option value="">Pilih Status</option>
                        <option value="I">Izin</option>
                        <option value="S">Sakit</option>
                        <option value="C">Cuti</option>
                        <option value="O">Off</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="detail[${index}][keterangan]" class="form-control" placeholder="Keterangan">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm btn-remove">🗑️</button>
                </div>
            `;
            container.appendChild(row);
            index++;
        });

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-remove')) {
                e.target.closest('.detail-row').remove();
            }
        });
    });
</script>
