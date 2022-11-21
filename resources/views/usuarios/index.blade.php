@extends('layouts.app')

@section('title')
    Usuarios |
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Usuarios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('CREAR-USUARIOS')
                                <a class="btn btn-info mb-4" href="{{ route('usuarios.create') }}"><i
                                        class="fas fa-user-plus"></i>
                                    Nuevo usuario</a>
                            @endcan
                            <table class="table table-striped my-2" id="usuarios">
                                <thead class="bg-success">
                                    <th style="color: #fff">Nombre completo</th>
                                    <th style="color: #fff">Correo electrónico</th>
                                    <th style="color: #fff">Rol</th>
                                    @can('EDITAR-USUARIOS')
                                        <th style="color: #fff">Acciones</th>
                                    @endcan
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $item)
                                        <tr>
                                            <td id="nombre">{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @if (!empty($item->getRoleNames()))
                                                    @foreach ($item->getRoleNames() as $rolName)
                                                        <h5><span class="badge badge-success">{{ $rolName }}</span>
                                                        </h5>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @can('EDITAR-USUARIOS')
                                                    <a class="btn btn-info" href="{{ route('usuarios.edit', $item->id) }}"><i
                                                            class="fas fa-user-edit"></i></a>
                                                @endcan
                                                @can('BORRAR-USUARIOS')
                                                    <form action="{{ route('usuarios.destroy', $item->id) }}" method="POST"
                                                        style="display:inline" class="frmDelete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger text-light"><i
                                                                class="fas fa-user-slash"></i></button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $('.frmDelete').submit(function(e) {
            e.preventDefault();
            swal({
                    title: 'Seguro de eliminar al usuario?',
                    text: "Si eliminas este registro no podrás recuperarlo",
                    icon: "warning",
                    showCancelButton: true,
                    buttons: true,
                    buttons: {
                        cancel: 'No, eliminar',
                        confirm: "Si, Eliminar",
                    },
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.submit();
                        swal("El registro de elimino de la base de datos", {
                            icon: "success",
                        });
                    }
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#usuarios').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "lengthMenu": "Mostrar " +
                        `<select class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value='5'>5</option>
                                        <option value='10'>10</option>
                                        <option value='15'>15</option>
                                        <option value='20'>20</option>
                                        <option value='25'>25</option>
                                        <option value='-1'>Todos</option>
                                    </select>` +
                        " registros por página",
                    "zeroRecords": "Aún no hay registros",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sin Registros Actualmente",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar: ",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
@endsection
