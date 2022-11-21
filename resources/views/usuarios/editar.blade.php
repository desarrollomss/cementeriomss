@extends('layouts.app')
@section('title')
Editar Usuario |
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar usuario</h3>
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

                        {!! Form::model($user,['method'=>'PUT','route'=>['usuarios.update',$user->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-5">
                                <div class="form-group">
                                    <label for="name">Nombre y Apellidos</label>
                                    {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Juan Perez Perez')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Ejemplo@correo.com')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Contraseña')) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="confirm-password">Confirmar Contraseña</label>
                                    {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirmar contraseña')) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="roles">Roles</label>
                                    {!! Form::select('roles[]', $roles, $userRol, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 d-flex justify-content-start">
                                <button type="submit" class="btn btn-success my-2 btn-block">Guardar</button>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 d-flex justify-content-end">
                                <a href="{{route('usuarios.index')}}" class="btn btn-danger my-2 btn-block" style="padding-bottom: -40px;"><i class="fas fa-undo-alt"></i> Volver</a>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
