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
                            <div class="col mb-3">
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
                            @csrf
                            <div class="row mb-2">
                                <div class="col-4 mb-2">
                                    <select name="tiporegistro" id="tiposregistros" class="form-control mb-2">
                                        <option selected disabled>SELECCIONAR</option>
                                        <option value="1">TUMBAS</option>
                                        <option value="2">MAUSOLEOS</option>
                                        <option value="3">CUARTELES</option>
                                    </select>
                                    <span class="text-danger">Selecciona un tipo de registro para exportar</span>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-success" disabled="disabled" id="exportartiporeg"><i class="fas fa-download"></i> EXPORTAR</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col my-2">
                                <h5>Consulta de Registros por Observación</h5>
                            </div>
                        </div>
                        <form action="{{route('consulta')}}" method="post">
                            @csrf
                            <div class="row my-2">
                                <div class="col-4 mb-2">
                                    <select name="observaciones" id="obs" class="form-control mb-2">
                                        <option selected disabled>SELECCIONAR</option>
                                        @foreach ($observaciones as $obs)
                                        <option value="{{$obs->id}}">{{$obs->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">Selecciona un tipo de registro para consultar</span>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-success" disabled="disabled" id="btnbuscar"><i class="fas fa-search"></i> BUSCAR</button>
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-success mb-3" href="#" id="btnexportarobs"><i class="fas fa-download"></i> Exportar Consulta</a>
                                </div>
                            </div>
                        </form>
                        <div class="row">
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
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {

        $('#obs').change(function () {
            $('#btnbuscar').removeAttr("disabled");
         });
        $('#tiposregistros').change(function () {
            $('#exportartiporeg').removeAttr("disabled");
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
    });
</script>
@endsection
