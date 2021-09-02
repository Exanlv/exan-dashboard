<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="" height="32" class="d-inline-block align-text-center">
            Exan
        </a>

        @if (request()->session()->has('discord-user'))
        <x-navigation-guild-menu />
        @else
        <a href="{{ route('auth.login') }}" class="btn btn-secondary">Login</a>
        @endif
        
    </div>
</nav>