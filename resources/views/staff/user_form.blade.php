<h2>{{ $user ? 'Edit Akun' : 'Buat Akun' }} untuk {{ $staff->nama }}</h2>

<form action="{{ route('staff.saveUser', $staff->id) }}" method="POST" autocomplete="off">
    @csrf

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" autocomplete="new-email" required>
        @error('email') <div>{{ $message }}</div> @enderror
    </div>

    <div>
        <label>Password {{ $user ? '(biarkan kosong jika tidak ingin mengganti)' : '' }}</label>
        <input type="password" name="password"  autocomplete="new-password">
        @error('password') <div>{{ $message }}</div> @enderror
    </div>

    <div>
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation">
    </div>

    <div>
        <label>Role</label>
        <select name="role" required>
            @foreach (['admin', 'karyawan', 'kepala'] as $role)
                <option value="{{ $role }}" {{ (old('role', $user->role ?? '') == $role) ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
        @error('role') <div>{{ $message }}</div> @enderror
    </div>

    <button type="submit">Simpan</button>
    <a href="{{ route('staff.view') }}">batal</a>
</form>
