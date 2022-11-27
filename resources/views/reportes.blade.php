@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte de Registros</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-sm-12 col-md-12 mb-2">
                                <h5>Consulta de Registros y Tiempo de Deceso</h5>
                            </div>
                        </div>
                        <form action="{{route('registrosporanio.export')}}" method="POST">
                            <div class="row my-2">
                                @csrf
                                <div class="col-xl-3 col-sm-12 col-md-8">
                                    <input type="number" class="form-control" style="width: 100%;" name="anio" id="anio">
                                </div>
                                <div class="col-xl-3 col-sm-12 col-md-8">
                                    <button type="submit" class="btn btn-success" disabled id="btnconsultar">CONSULTAR</button>
                                </div>
                                @if (session()->has('rpta'))
                                <div class="col-xl-6 col-sm-12 col-md-8">
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <strong>{{ session()->get('rpta') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>


                        <div class="row">
                            <div class="col-xl-12 col-sm-12 col-md-12 mb-2">
                                <h5>Exportacion de Registros Generales</h5>
                                @if (session()->has('success'))
                                <div class="alert alert-info alert-dismissible fade show mensaje" role="alert">
                                    <strong>{{ session()->get('success') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                        <form action="{{route('registros.export')}}" method="post">
                            <div class="row mb-2">
                                @csrf
                                <div class="col-xl-3 col-sm-12 col-md-12">
                                    <select name="tiporegistro" id="tiposregistros" class="form-control mb-2">
                                        <option selected disabled>SELECCIONAR</option>
                                        <option value="1">TUMBAS</option>
                                        <option value="2">MAUSOLEOS</option>
                                        <option value="3">CUARTELES</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-success" disabled="disabled" id="exportartiporeg"><em class="fas fa-download"></em> EXPORTAR</button>
                                </div>
                            </div>
                        </form>


                        <div class="row">
                            <div class="col-xl-12 col-sm-12 col-md-12">
                                <h5>Consulta de Registros por Observación</h5>
                            </div>
                        </div>
                        <form action="{{route('consulta')}}" method="post">
                            <div class="row my-2">
                                @csrf
                                <div class="col-xl-6 col-sm-12 col-md-8">
                                    <select name="observaciones" id="obs" class="form-control mb-2">
                                        <option selected disabled>SELECCIONAR</option>
                                        @foreach ($observaciones as $obs)
                                        <option value="{{$obs->id}}">{{$obs->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-3 col-sm-12 col-md-2">
                                    <button type="submit" class="btn btn-success" disabled="disabled" id="btnbuscar"><em class="fas fa-search"></em> BUSCAR</button>
                                </div>
                                <div class="col-xl-3 col-sm-12 col-md-2 d-flex justify-content-end">
                                    <a class="btn btn-success mb-3" href="#" id="btnexportarconsulta"><em class="fas fa-download"></em> Exportar Consulta</a>
                                    <input type="hidden" name="id_obs" id="validobs">
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-xl-12 col-sm-12 col-md-12">
                                <table class="table table-responsive table-hover table-striped mt-4" id="consulta">
                                    <thead class="bg-success">
                                        <th style="color: #fff">Ubicación</th>
                                        <th style="color: #fff">Nivel</th>
                                        <th style="color: #fff">Número</th>
                                        <th style="color: #fff">Nombres</th>
                                        <th style="color: #fff">A. Paterno</th>
                                        <th style="color: #fff">A. Materno</th>
                                        <th style="color: #fff">Fecha Deceso</th>
                                        <th style="color: #fff">Observaciones</th>
                                        <th style="color: #fff">Adicionales</th>
                                    </thead>
                                    @if ($respuesta = Session::get('resp'))
                                    <tbody>
                                        @foreach ($respuesta as $rsp)
                                        <tr>
                                            <td>{{$rsp->ubicacion}}</td>
                                            <td>{{$rsp->nivel}}</td>
                                            <td>{{$rsp->numero}}</td>
                                            <td>{{$rsp->nombres}}</td>
                                            <td>{{$rsp->paterno}}</td>
                                            <td>{{$rsp->materno}}</td>
                                            @if ($rsp->fecha_deceso == null)
                                            <td>SIN FECHA</td>
                                            @else
                                            <td>{{$rsp->fecha_deceso}}</td>
                                            @endif
                                            <td>{{$rsp->observaciones}}</td>
                                            <td>{{$rsp->adicionales}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {

        $('#anio').on('focus', function() {
            $('#btnconsultar').removeAttr("disabled");
        });

        $('#tiposregistros').change(function() {
            $('#exportartiporeg').removeAttr("disabled");
        });
        $('#obs').change(function() {
            $('#btnbuscar').removeAttr("disabled");
            var seleccion = $('select[name=observaciones]').val();
            var valor = $('input[name=id_obs]').val(seleccion);
            var id = valor.val();
            $(document).find('#btnexportarconsulta').attr('href', `/cementerio/export/${id}/filtro`);
        });

        $('#consulta').DataTable({
            "order": [
                [0, "asc"]
            ],
            responsive: true,
            autoWidth: false,
            info: true,
            "pageLength": 50,
            "aLengthMenu": [
                [50, 100, 150, 200, 250, -1],
                [50, 100, 150, 200, 250, "Todos"]
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

        function validarNumericos() {
            if ($('#anio').val() > 9999) {
                $('#errorcode').css("display", "block");
                $('#anio').css("border", "1px solid red");
                $('#anio').focus();
                event.preventDefault();
                return false;
            } else {
                return true;
            }
        }

    });
</script>
@endsection
