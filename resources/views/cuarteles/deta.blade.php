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
            <h3 class="page__heading">Detalle de: {{$cuartel->nombres}} {{$cuartel->ap_paterno}} {{$cuartel->ap_materno}}</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                              <div class="row">                                
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="fecha">Fecha y hora del registro</label>
                                        <p class="text-primary">{{$cuartel->created_at}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        @if ($cuartel->imagen == 'null' || $cuartel->imagen == '')
                                            <img id="imagenSeleccionada" src="{{asset('/imagen/tumba.png')}}" width="150" height="150">                                                                                        
                                        @else
                                            <img id="imagenSeleccionada" src="{{asset('/imagen/'.$cuartel->imagen) }}">   
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="obs">Ultima actualización</label>
                                        <p class="text-primary">{{$cuartel->updated_at}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
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
</script>
