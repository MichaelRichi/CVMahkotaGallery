@if (Route::has('login'))
    @auth
        <a href="{{ url('/dashboard') }}">Dashboard</a>
    @else
        <a href="{{ route('login') }}"> Log in</a>
    @endauth
@endif