@can('ver-registers')
<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{{url('/home')}}">
        <i class="fas fa-home"></i><span>Resumenes</span>
    </a>
</li>
@endcan
@can('ver-registers')
<li class="side-menus {{ Request::is('cementerio/reportes') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('reportes.general')}}">
        <i class="fas fa-tachometer-alt"></i><span>Reportes</span>
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
<li class="side-menus {{ Request::is('cementerio/registros/cuarteles') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('cuarteles.index')}}">
        <i class="fas fa-hospital-alt"></i><span>Cuarteles</span>
    </a>
</li>
<li class="side-menus {{ Request::is('cementerio/registros/mausoleos') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('mausoleos.index')}}">
        <i class="fas fa-clinic-medical"></i><span>Mausoleos</span>
    </a>
</li>
<li class="side-menus {{ Request::is('cementerio/registros/tumbas') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('tumbas.index')}}">
        <i class="fas fa-cross"></i><span>Tumbas</span>
    </a>
</li>
@endcan

