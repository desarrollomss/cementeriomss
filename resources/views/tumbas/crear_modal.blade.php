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

    .caja {
        background-color: transparent;
        border: 0px;
        outline: none;
        border-bottom: 1px solid #0DA8EE;
        width: 95%;
    }

    .titulos {
        color: #0DA8EE;
    }
</style>
<div class="modal fade" id="creartumba" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                <form action="{{route('tumbas.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="codigo">Codigo</label>
                                <select class="form-control" id="codigo" required>
                                    <option selected value="0">Seleccionar</option>
                                    @foreach ($ubicacion as $item)
                                    <option value="{{$item->id}}">{{$item->codigo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ubicacion">Ubicación</label>
                                <select class="form-control" id="ubicacion" required>
                                    <option selected value="0">Seleccionar</option>
                                    <option>TUMBAS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="nivel">Nivel</label>
                                <select class="form-control" id="nivel" required>
                                    <option selected value="0">Seleccionar</option>
                                    @foreach ($niveles as $nivel)
                                    <option value="{{$nivel->id}}">{{$nivel->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="nro">Nro</label>
                                <input type="number" required id="nro" name="numero" placeholder="Nro" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="nombres">Nombres</label>
                                <input type="text" required id="nombres" name="nombres" placeholder="Nombres" class="form-control" onkeyup="mayus(this);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="apaterno">Apellido parterno</label>
                                <input type="text" required id="aparteno" name="ap_paterno" placeholder="Apellido Parterno" class="form-control" onkeyup="mayus(this);">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="amaterno">Apellido marterno</label>
                                <input type="text" required id="aparteno" name="ap_materno" placeholder="Apellido Marterno" class="form-control" onkeyup="mayus(this);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="fecha">Fecha de deceso</label>
                                <input type="date" id="fecha" name="fecha_deceso" placeholder="Fecha de Deceso" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="fecha">Imagen</label>
                                <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <img id="imagenSeleccionada" style="max-height: 300px" class="mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="observacion">Observaciones</label>
                                @foreach ($observaciones as $obs)
                                <div class="form-check">
                                    <input class="form-check-input" name="observacion" type="checkbox" value="{{$obs->id}}">
                                    <label class="form-check-label">
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
                                    <input class="form-check-input" name="adicional" type="checkbox" value="{{$ad->id}}">
                                    <label class="form-check-label">
                                        {{ $ad->descripcion }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 justify-content-end my-2">
                            <button type="submit" class="btn btn-success btn-block">Guardar</button>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 d-flex justify-content-end my-2">
                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fas fa-undo-alt"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
