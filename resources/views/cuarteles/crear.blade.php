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
                        <form action="{{route('cuarteles.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="2" name="tiporegistro">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-5">
                                    <div class="form-group">
                                        <label for="ubicacion">Ubicación</label>
                                        <select class="form-control" name="ubicacion" id="ubicacion" required>
                                            <option selected value="0" disabled>Seleccionar</option>
                                            @foreach ($ubicacion as $ubic)
                                            <option value="{{$ubic->id}}">{{$ubic->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2">
                                    <div class="form-group">
                                        <label for="nivel">Nivel</label>
                                        <select class="form-control" name="nivel" id="nivel" required>
                                            <option selected value="0" disabled>Seleccionar</option>
                                            @foreach ($niveles as $nivel)
                                            <option value="{{$nivel->id}}">{{$nivel->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2">
                                    <div class="form-group">
                                        <label for="nro">Nro</label>
                                        <input type="number" required id="nro" name="numero" placeholder="Nro" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="nombres">Nombres</label>
                                        <input type="text" required id="nombres" name="nombres" placeholder="Nombres" class="form-control" onkeyup="mayus(this);">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="apaterno">Apellido parterno</label>
                                        <input type="text" required id="aparteno" name="paterno" placeholder="Apellido Parterno" class="form-control" onkeyup="mayus(this);">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="amaterno">Apellido marterno</label>
                                        <input type="text" required id="aparteno" name="materno" placeholder="Apellido Marterno" class="form-control" onkeyup="mayus(this);">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha de deceso</label>
                                        <input type="date" id="fecha" name="fecha_deceso" placeholder="Fecha de Deceso" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <img id="imagenSeleccionada" style="max-height: 200px">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="observacion">Observaciones</label>
                                        @foreach ($observaciones as $obs)
                                        <div class="form-check">
                                            <input class="form-check-input" id="obss{{ $obs->id }}" name="observaciones[]" type="checkbox" value="{{$obs->id}}">
                                            <label class="form-check-label" for="obss{{ $obs->id }}">
                                                {{ $obs->descripcion }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="adicionales">Adicionales</label>
                                        @foreach ($adicionales as $ad)
                                        <div class="form-check">
                                            <input class="form-check-input" id="add{{ $ad->id }}" name="adicionales[]" type="checkbox" value="{{$ad->id}}">
                                            <label class="form-check-label" for="add{{ $ad->id }}">
                                                {{ $ad->descripcion }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 d-flex justify-content-start">
                                    <button type="submit" class="btn btn-success my-2 btn-block">Guardar</button>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2 d-flex justify-content-end">
                                    <a href="{{route('cuarteles.index')}}" class="btn btn-danger my-2 btn-block" style="padding-bottom: -40px;"><i class="fas fa-undo-alt"></i> Volver</a>
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
        $('#codigo').focus();
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
