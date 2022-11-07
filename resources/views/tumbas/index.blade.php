@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registros de Tumbas</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    @can('crear-registers')
                                        <a class="btn btn-info mb-3" href="{{ route('tumbas.create') }}"><em
                                                class="fas fa-check-square"></em> Nuevo registro</a>
                                    @endcan
                                </div>
                                <div class="col">
                                    <a class="btn btn-primary mb-3" href="{{ route('exportarTumbas') }}">Exportar a
                                        Excel</a>
                                </div>
                                <form action="{{ route('tumbas.index') }}" class="mr-3" method="GET">
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="text" class="form-control" name="texto" placeholder="Buscar..."
                                                value="{{ $texto }}" onkeyup="mayus(this);">
                                        </div>
                                        <div class="col">
                                            <input type="submit" class="btn btn-warning mt-1" value="Buscar">
                                            <a href="{{ route('tumbas.index') }}" class="btn btn-info mt-1">Limpiar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table class="table table-responsive table-hover table-striped mt-2">
                                <thead class="bg-success">
                                    <th style="color: #fff">Codigo</th>
                                    <th style="color: #fff">Ubicación</th>
                                    <th style="color: #fff">Nivel</th>
                                    <th style="color: #fff">Nro</th>
                                    <th style="color: #fff">Nombres</th>
                                    <th style="color: #fff">A. Paterno</th>
                                    <th style="color: #fff">A. Materno</th>
                                    <th style="color: #fff">Fecha Deceso</th>
                                    <th style="color: #fff">Observ</th>
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
                                        @foreach ($tumbas as $tumba)
                                            <tr>
                                                <td>{{ $tumba->codigo }}</td>
                                                <td>{{ $tumba->ubicacion }}</td>
                                                <td>{{ $tumba->nivel }}</td>
                                                <td>{{ $tumba->numero }}</td>
                                                <td>{{ $tumba->nombres }}</td>
                                                <td>{{ $tumba->ap_paterno }}</td>
                                                <td>{{ $tumba->ap_materno }}</td>
                                                <td>{{ $tumba->fecha_deceso }}</td>
                                                <td>{{ $tumba->obs }}</td>
                                                <td width="280px">
                                                    @can('ver-registers')
                                                        <a class="btn btn-success"
                                                            href="{{ route('tumbas.show', $tumba->id) }}">
                                                            <em class="fas fa-eye"></em>
                                                        </a>
                                                    @endcan
                                                </td>
                                                <td width="280px">
                                                    @can('editar-registers')
                                                        <a class="btn btn-info"
                                                            href="{{ route('tumbas.edit', $tumba->id) }}"><i
                                                                class="fas fa-user-edit"></i></a>
                                                    @endcan
                                                </td>
                                                <td width="280px">
                                                    @can('borrar-registers')
                                                        <form action="{{ route('tumbas.destroy', $tumba->id) }}"
                                                            method="POST" style="display:inline" class="frmDelete">
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
                            <table class="table table-responsive mt-2 d-flex justify-content">
                                <td colspan="8">
                                    {{ $tumbas->appends(['texto' => $texto])->links() }}
                                </td>
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
    </script>

@endsection
