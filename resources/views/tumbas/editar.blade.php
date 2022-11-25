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
        <h3 class="page__heading">Editar registro</h3>
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
                        <form action="{{route('tumbas.update',$registro->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="3" name="tiporegistro" value="{{$registro->id_tipo_reg}}">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-2">
                                    <div class="form-group">
                                        <label for="ubicacion">Codigo</label>
                                        <select class="form-control" name="ubicacion" id="codigo">
                                            <option selected value="0" disabled>Seleccionar</option>
                                            @foreach ($ubicacion as $item)
                                            <option selected value="{{$item->id}}">{{$item->codigo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="nivel">Nivel</label>
                                        <select class="form-control" name="nivel" id="nivel">
                                            <option selected value="0" disabled>Seleccionar</option>
                                            @foreach ($niveles as $item)
                                            <option selected value="{{$item->id}}">{{$item->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="nro">Nro</label>
                                        <input type="number" id="nro" name="numero" placeholder="Nro" class="form-control" value="{{ $registro->numero }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="nombres">Nombres</label>
                                        <input type="text" id="nombres" name="nombres" placeholder="Nombres" class="form-control" value="{{ $registro->nombres }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="apaterno">Apellido parterno</label>
                                        <input type="text" id="aparteno" name="paterno" placeholder="Apellido Parterno" class="form-control" value="{{ $registro->paterno }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="amaterno">Apellido marterno</label>
                                        <input type="text" id="aparteno" name="materno" placeholder="Apellido Marterno" class="form-control" value="{{ $registro->materno }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha de deceso</label>
                                        <input type="date" id="fecha" name="fecha_deceso" class="form-control" value="{{ $registro->fecha_deceso }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        @if($registro->imagen != null)
                                        <img id="imagenSeleccionada" style="max-height: 230px;" src="{{asset('/imagen/'.$registro->imagen)}}" alt="Imagen" class="my-3">
                                        @else
                                        <img id="imagenSeleccionada" style="max-height: 230px;" src="{{asset('/imagen/default.png')}}" alt="Imagen" class="my-3">
                                        @endif
                                        <button class="btn btn-danger ml-4" type="button" onclick="quitarimagen();"><em class="fas fa-trash"></em></button>
                                        &nbsp;
                                        <label style="font-size: 15px !important;">Quitar Imagen</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="obs">Observaciones</label>
                                        @foreach ($observaciones as $obs)
                                        <div class="form-check">
                                            <input class="form-check-input" id="obss{{ $obs->id }}" name="observaciones[]" type="checkbox" value="{{$obs->id}}" {{ in_array($obs->id, $obsreg) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="obss{{ $obs->id }}">
                                                {{ $obs->descripcion }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="obs">Adicionales</label>
                                        @foreach ($adicionales as $ads)
                                        <div class="form-check">
                                            <input class="form-check-input" id="ads{{ $ads->id }}" name="adicionales[]" type="checkbox" value="{{$ads->id}}" {{ in_array($ads->id, $adsreg) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ads{{ $ads->id }}">
                                                {{ $ads->descripcion }}
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
                                    <a href="{{route('tumbas.index')}}" class="btn btn-danger my-2 btn-block" style="padding-bottom: -40px;"><i class="fas fa-undo-alt"></i> Volver</a>
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
    function quitarimagen() {
        let defaultimg = "{{asset('/imagen/default.png')}}";
        $('#imagenSeleccionada').attr("src", defaultimg);
    }

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
</script>
@endsection
