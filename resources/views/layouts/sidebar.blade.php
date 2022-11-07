<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logo.png') }}" width="175"
             alt="Logo munisurco">
        <a href="{{ url('home') }}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('home') }}" class="small-sidebar-text">
            <img class="navbar-brand-full" src="{{ asset('img/escudo.png') }}" width="48px" alt=""/>
        </a>
    </div>
    <ul class="sidebar-menu">
        @include('layouts.menu')
    </ul>
</aside>
