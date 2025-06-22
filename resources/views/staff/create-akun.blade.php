<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Buat Akun untuk: {{ $staff->nama }}</h2>
    </x-slot>

    <form method="POST" action="{{ route('register.staff.store', $staff->id) }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input type="email" name="email" value="{{ old('email') }}" class="block mt-1 w-full" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input type="password" name="password" class="block mt-1 w-full" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input type="password" name="password_confirmation" class="block mt-1 w-full" required />
        </div>

        <div class="mt-4">
            <x-input-label for="role" value="Role" />
            <select name="role" class="block mt-1 w-full" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="kepala">Kepala Cabang</option>
                <option value="karyawan">Karyawan</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button>Buat Akun</x-primary-button>
        </div>
    </form>
</x-app-layout>
