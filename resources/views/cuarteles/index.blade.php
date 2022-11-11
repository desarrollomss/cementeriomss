@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Listado de Cuarteles</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                @can('crear-registers')
                                <a class="btn btn-info mb-3" href="#"><em class="fas fa-check-square"></em> Nuevo registro</a>
                                @endcan
                            </div>
                        </div>

                        <table class="table table-responsive table-hover table-striped mt-2" id="cuarteles">
                            <thead class="bg-success">
                                <th style="color: #fff">Ubicación</th>
                                <th style="color: #fff">Nivel</th>
                                <th style="color: #fff">Nro</th>
                                <th style="color: #fff">Nombres</th>
                                <th style="color: #fff">A. Paterno</th>
                                <th style="color: #fff">A. Materno</th>
                                <th style="color: #fff">Fecha Deceso</th>
                                <th style="color: #fff">Observacion</th>
                                @can('ver-registers')
                                <th style="color: #fff">Ver</th>
                                @endcan
                                @can('editar-registers')
                                <th style="color: #fff">Editar</th>
                                @endcan
                                @can('borrar-registers')
                                <th style="color: #fff">Eliminar</th>
                                @endcan
                            </thead>
                            <tbody>
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
                title: 'Seguro de eliminar?',
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

    $(document).ready(function(e) {
        $('#imagen').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });

    function mayus(e) {
        e.value = e.value.toUpperCase();
    }


    $(document).ready(function() {
        $('#cuarteles').DataTable({
            proccesing: true,
            info: true,
            "order": [
                [0, "desc"]
            ],
            responsive: true,
            autoWidth: false,
            processing: true,
            info: true,
            "pageLength": 50,
            "ajax": "{{route('obtener.cuarteles')}}",
            "columns": [{
                    data: 'ubicacion'
                },
                {
                    data: 'nivel'
                },
                {
                    data: 'numero'
                },
                {
                    data: 'nombres'
                },
                {
                    data: 'paterno'
                },
                {
                    data: 'materno'
                },
                {
                    data: 'fecha_deceso'
                },
                {
                    data: 'observaciones'
                },
                {
                    data: 'ver'
                },
                {
                    data: 'editar'
                },
                {
                    data: 'eliminar'
                }
            ],
            "language": {
                "lengthMenu": "Mostrar " +
                    `<select class="custom-select custom-select-sm form-control form-control-sm">
                            <option value='5'>50</option>
                            <option value='10'>100</option>
                            <option value='15'>150</option>
                            <option value='20'>200</option>
                            <option value='25'>250</option>
                            <option value='-1'>Todos</option>
                        </select>` +
                    " registros por página",
                "zeroRecords": "Sin Resultados Actualmente",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Sin Resultados",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar: ",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
    });
</script>
@endsection
