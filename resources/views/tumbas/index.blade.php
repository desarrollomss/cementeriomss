@extends('layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Listado de Tumbas</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                @can('crear-registers')
                                <a class="btn btn-info mb-3" href="{{ route('tumbas.create') }}"><em class="fas fa-check-square"></em> Nuevo registro</a>
                                @endcan
                            </div>
                        </div>
                        <table class="table table-responsive table-hover table-striped mt-2" id="tumbas">
                            <thead class="bg-success">
                                <th style="color: #fff">Codigo</th>
                                <th style="color: #fff">Ubicación</th>
                                <th style="color: #fff">Nivel</th>
                                <th style="color: #fff">Nro</th>
                                <th style="color: #fff">Nombres</th>
                                <th style="color: #fff">A.Paterno</th>
                                <th style="color: #fff">A.Materno</th>
                                <th style="color: #fff">Fecha Deceso</th>
                                <th style="color: #fff">Observ</th>
                                @can('ver-registers')
                                <th style="color: #fff" colspan="3">Acciones</th>
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
@include('tumbas.deta_modal')
@endsection
@section('scripts')

<script>
    $('#frmDelete').submit(function(e) {
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
        $('#tumbas').DataTable({
            proccesing: true,
            info: true,
            "order": [
                [0, "asc"]
            ],
            responsive: true,
            autoWidth: false,
            processing: true,
            info: true,
            "pageLength": 50,
            "aLengthMenu": [
                [50, 100, 150, 200, 250, -1],
                [50, 100, 150, 200, 250, "Todos"]
            ],
            "ajax": "{{route('obtener.tumbas')}}",
            "columns": [
                {data: 'codigo'},
                {data: 'ubicacion'},
                {data: 'nivel'},
                {data: 'numero'},
                {data: 'nombres'},
                {data: 'paterno'},
                {data: 'materno'},
                {data: 'fecha_deceso'},
                {data: 'observaciones'},
                {data: 'ver'},
                {data: 'editar'},
                {data: 'borrar'}
            ],
            "language": {
                "lengthMenu": "Mostrar " +
                    `<select class="custom-select custom-select-sm form-control form-control-sm">
                            <option value='50'>50</option>
                            <option value='100'>100</option>
                            <option value='150'>150</option>
                            <option value='200'>200</option>
                            <option value='250'>250</option>
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

    $(document).on('click','#modalTumbasDeta', function(){
        var id = $(this).data('id');
        $.get('<?= route("detalle.tumbas") ?>',{id:id}, function (data) {
            $('.tumbadetalle').find('input[name="nombres"]').val(data.detalle[0].nombres);
            $('.tumbadetalle').find('input[name="paterno"]').val(data.detalle[0].paterno);
            $('.tumbadetalle').find('input[name="materno"]').val(data.detalle[0].materno);
            $('.tumbadetalle').find('input[name="observaciones"]').val(data.detalle[0].observacion);
            $('.tumbadetalle').find('input[name="fecha_deceso"]').val(data.detalle[0].fecha_deceso);
            $('.tumbadetalle').find("#imgdetalle").attr("src", data.detalle[0].imagen);
            $('.tumbadetalle').modal('show');
         },'json');
    });
</script>

@endsection
