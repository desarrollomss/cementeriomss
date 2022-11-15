@extends('layouts.app')
@section('title')
Editar Rol |
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar el Rol</h3>
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
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-5">
                                <div class="form-group">
                                    <h6>ASIGNAR PERMISOS PARA EL ROL</h6>
                                </div>
                            </div>
                        </div>

                        {!! Form::model($role,['method'=>'PUT','route'=>['roles.update',$role->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-5">
                                <div class="form-group">
                                    <label for="name">Nombre del rol</label>
                                    {!! Form::text('name', null, array('class'=>'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-7">
                                <div class="form-group">
                                    @foreach($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermission) ? true : false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                    <br />
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-1 d-flex justify-content-start">
                                <button type="submit" class="btn btn-success my-2 btn-block">Guardar</button>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 d-flex justify-content-end">
                                <a href="{{route('roles.index')}}" class="btn btn-danger my-2 btn-block" style="padding-bottom: -40px;"><i class="fas fa-undo-alt"></i> Volver</a>
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
