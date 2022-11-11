@can('ver-registers')
<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/home')}}">
        <i class="fas fa-tachometer-alt"></i><span>Resumenes</span>
    </a>
</li>
@endcan
@can('ver-users')
    <li class="side-menus {{ Request::is('usuarios') ? 'active' : '' }}">
        <a class="nav-link" href="{{url('/usuarios')}}">
            <i class="fas fa-users"></i><span>Usuarios</span>
        </a>
    </li>
@endcan
@can('ver-rols')
    <li class="side-menus {{ Request::is('roles') ? 'active' : '' }}">
        <a class="nav-link" href="{{url('/roles')}}">
            <i class="fas fa-cogs"></i><span>Roles</span>
        </a>
    </li>
@endcan
@can('ver-registers')
<li class="side-menus {{ Request::is('cuarteles') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/cuarteles')}}">
        <i class="fas fa-hospital-alt"></i><span>Cuarteles</span>
    </a>
</li>
<!-- <li class="side-menus {{ Request::is('mausoleos') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/mausoleos')}}">
        <i class="fas fa-clinic-medical"></i><span>Mausoleos</span>
    </a>
</li>
<li class="side-menus {{ Request::is('tumbas') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/tumbas')}}">
        <i class="fas fa-cross"></i><span>Tumbas</span>
    </a>
</li> -->
@endcan

