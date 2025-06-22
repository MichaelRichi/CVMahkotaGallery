
<h2>Daftar Staff</h2>

<a href="{{ route('staff.addView') }}" class="btn btn-primary">
    + Tambah Staff
</a>
<form method="GET" action="{{ route('staff.view') }}">
    <select name="is_active">
        <option value="">-- Semua Status --</option>
        <option value="1" {{ request('is_active')=='1' ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ request('is_active')=='0' ? 'selected' : '' }}>Tidak Aktif</option>
    </select>

    <select name="cabang_id">
        <option value="">-- Semua Cabang --</option>
        @foreach($cabang as $c)
            <option value="{{ $c->id }}" {{ request('cabang_id')==$c->id ? 'selected' : '' }}>
                {{ $c->nama_cabang }}
            </option>
        @endforeach
    </select>

    <select name="jabatan_id">
        <option value="">-- Semua Jabatan --</option>
        @foreach($jabatan as $j)
            <option value="{{ $j->id }}" {{ request('jabatan_id')==$j->id ? 'selected' : '' }}>
                {{ $j->nama_jabatan }}
            </option>
        @endforeach
    </select>

    <button type="submit">Filter</button>
</form>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIK</th>
            <th>Cabang</th>
            <th>Jabatan</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($staff as $s)
            <tr>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->NIK }}</td>
                <td>{{ $s->jabatan->first()->nama_jabatan ?? '-' }}</td>
                <td>{{ $s->cabang->first()->nama_cabang ?? '-' }}</td>
                <td>{{ $s->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                <td>
                    <a href="{{ route('staff.editView', $s->id) }}">edit</a>
                    @auth
                        @if (auth()->user()->role === 'admin')
                            @if ($s->users_id)
                                <a href="{{ route('staff.userForm', $s->id) }}">Edit Akun</a>
                            @else
                                <a href="{{ route('staff.userForm', $s->id) }}">Buat Akun</a>
                            @endif
                        @endif
                    @endauth
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Tidak ada data staff.</td></tr>
        @endforelse
    </tbody>
</table>