@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Roles</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-rols')
                                <a class="btn btn-info my-2" href="{{ route('roles.create') }}"><i class="fas fa-cog"></i> Nuevo
                                    rol</a>
                            @endcan
                            <table class="table table-striped mt-2" id="roles">
                                <thead class="bg-success">
                                    <th style="color: #fff">Rol</th>
                                    @can('editar-rols')
                                        <th style="color: #fff">Acciones</th>
                                    @endcan
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            @can('editar-rols')
                                                <td>
                                                    <a class="btn btn-warning" href="{{ route('roles.edit', $role->id) }}"><i
                                                            class="fas fa-edit"></i></a>
                                                @endcan
                                                @can('borrar-rols')
                                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                        style="display:inline" class="frmDelete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger text-light">
                                                            <i class="fas fa-minus-square"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
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
                    title: 'Seguro de eliminar este rol?',
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
                        swal("El registro se elimino de la base de datos", {
                            icon: "success",
                        });
                    } 
                });
        });
    </script>
     <script>
        $(document).ready(function() {
            $('#roles').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "lengthMenu": "Mostrar "+
                                    `<select class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value='5'>5</option>
                                        <option value='10'>10</option>
                                        <option value='15'>15</option>
                                        <option value='20'>20</option>
                                        <option value='25'>25</option>
                                        <option value='-1'>Todos</option>
                                    </select>`
                                    +" registros por página",
                    "zeroRecords": "Aún no hay registros",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar: ",
                    "paginate": {
                        "next":"Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
@endsection
