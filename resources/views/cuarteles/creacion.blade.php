@extends('layouts.app')
@section('css')
    <style>
        #imagenSeleccionada {
            max-width: 60%;
            display: inline-block;
        }

        @media (min-width: 355px) {
            #imagenSeleccionada {
                max-width: 100%;
            }
        }

        @media (min-width: 330px) {
            #imagenSeleccionada {
                max-width: 100%;
            }
        }

        @media (min-width: 760px) {
            #imagenSeleccionada {
                max-width: 50%;
            }
        }

    </style>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Nuevo registro</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- Alerta validacion --}}
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>¡Revise los campos!</strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form action="{{ route('cuarteles.store') }}" method="post" class="form-horizontal"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="ubicacion">Ubicación</label>
                                            <input type="text" name="ubicacion" list="ubicacion" class="form-control">
                                            <datalist id="ubicacion">
                                                @foreach ($cuarteles_info as $cinfo)
                                                    <option value="{{ $cinfo->descripcion }}">{{ $cinfo->descripcion }}
                                                    </option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label for="nivel">Nivel</label>
                                            <input type="text" name="nivel" list="nivel" class="form-control" required>
                                            <datalist id="nivel">
                                                @foreach ($niveles as $niv)
                                                    <option value="{{ $niv->descripcion }}">{{ $niv->descripcion }}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label for="nro">Nro</label>
                                            <input type="number" required id="nro" name="numero" placeholder="Nro"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nombres">Nombres</label>
                                            <input type="text" required id="nombres" name="nombres" placeholder="Nombres"
                                                class="form-control" onkeyup="mayus(this);">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="apaterno">Apellido parterno</label>
                                            <input type="text" required id="aparteno" name="ap_paterno"
                                                placeholder="Apellido Parterno" class="form-control" onkeyup="mayus(this);">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="amaterno">Apellido marterno</label>
                                            <input type="text" required id="aparteno" name="ap_materno"
                                                placeholder="Apellido Marterno" class="form-control" onkeyup="mayus(this);">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="fecha">Fecha de deceso</label>
                                            <input type="text" required id="fecha" name="fecha_deceso"
                                                placeholder="Fecha de Deceso" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8">
                                        <div class="form-group">
                                            <img id="imagenSeleccionada" style="max-height: 200px">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="obs">Observaciones</label>
                                            <input type="text" name="obs" list="obs" class="form-control" required>
                                            <datalist id="obs">
                                                @foreach ($observaciones as $obs)
                                                    <option value="{{ $obs->observaciones }}">{{ $obs->observaciones }}
                                                    </option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
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



