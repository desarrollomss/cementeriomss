@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear rol</h3>
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

                            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-5">
                                    <div class="form-group">
                                        <label for="name">Nombre del rol</label>
                                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombra el rol']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-7">
                                    <div class="form-group">
                                        <label>Permisos para este rol</label>
                                        <br>
                                        @foreach ($permission as $item)
                                        <label>{!! Form::checkbox('permission[]', $item->id, false, ['class' => 'name']) !!}
                                            {{$item->name}}</label>
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
