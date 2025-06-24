<h1>{{ Auth::user()->email }}</h1>
<form method="POST" action="{{ route('logout') }}">
    @csrf

    <x-dropdown-link :href="route('logout')"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
        {{ __('Log Out') }}
    </x-dropdown-link>
</form>

<h2>menu</h2>
<li><a href="{{ route('staff.view') }}">data Staff</a></li>
@auth
    @if (auth()->user()->role === 'admin')
        <li><a href="{{ route('cabang.view') }}">data cabang</a></li>
        <li><a href="{{ route('jabatan.view') }}">data jabatan</a></li>     
        <li><a href="{{ route('kronologi.view') }}">data pengajuan kronologi</a></li> 
        <li><a href="{{ route('pengajuanizin.view') }}">data pengajuan izin</a></li> 
    @endif
    @if (auth()->user()->role === 'kepala')
        <li><a href="{{ route('kronologi.view') }}">data pengajuan kronologi</a></li> 
    @endif
@endauth
<li><a href="{{ route('pengajuanizin.addView') }}">ajukan izin</a></li>
<li><a href="{{ route('kronologi.addView') }}">ajukan kronologi</a></li>
<li><a href="{{ route('pengajuanizin.riwayat') }}">riwayat pengajuan izin</a></li>
<li><a href="{{ route('kronologi.riwayat') }}">riwayat pengajuan kronologi</a></li>