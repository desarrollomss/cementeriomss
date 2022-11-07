@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registros de Mausoleos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    @can('crear-registers')
                                        <a class="btn btn-info mb-3" href="{{ route('mausoleos.create') }}"><em
                                                class="fas fa-check-square"></em> Nuevo registro</a>
                                    @endcan
                                </div>
                                <div class="col">
                                    <a class="btn btn-primary mb-3" href="{{ route('exportarMausoleos') }}">Exportar a
                                        Excel</a>
                                </div>
                                <form action="{{ route('mausoleos.index') }}" class="mr-3" method="GET">
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="text" class="form-control" name="texto" placeholder="Buscar..."
                                                value="{{ $texto }}" onkeyup="mayus(this);">
                                        </div>
                                        <div class="col">
                                            <input type="submit" class="btn btn-warning mt-1" value="Buscar">
                                            <a href="{{ route('mausoleos.index') }}" class="btn btn-info mt-1">Limpiar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table class="table table-responsive table-hover table-striped mt-2">
                                <thead class="bg-success">
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
                                        @foreach ($mausoleos as $mausoleo)
                                            <tr>
                                                <td>{{ $mausoleo->ubicacion }}</td>
                                                <td>{{ $mausoleo->nivel }}</td>
                                                <td>{{ $mausoleo->numero }}</td>
                                                <td>{{ $mausoleo->nombres }}</td>
                                                <td>{{ $mausoleo->ap_paterno }}</td>
                                                <td>{{ $mausoleo->ap_materno }}</td>
                                                <td>{{ $mausoleo->fecha_deceso }}</td>
                                                <td>{{ $mausoleo->obs }}</td>
                                                <td width="200px">
                                                    @can('ver-registers')
                                                        <a class="btn btn-success"
                                                            href="{{ route('mausoleos.show', $mausoleo->id) }}">
                                                            <em class="fas fa-eye"></em>
                                                        </a>
                                                    @endcan
                                                </td>
                                                <td style="width: 200px">
                                                    @can('editar-registers')
                                                        <a class="btn btn-info"
                                                            href="{{ route('mausoleos.edit', $mausoleo->id) }}"><i
                                                                class="fas fa-user-edit"></i></a>
                                                    @endcan
                                                </td>
                                                <td style="width: 200px">
                                                    @can('borrar-registers')
                                                        <form action="{{ route('mausoleos.destroy', $mausoleo->id) }}"
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
                                    {{ $mausoleos->appends(['texto' => $texto])->links() }}
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
