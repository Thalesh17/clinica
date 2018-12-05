@extends('layouts.default')

@section('content')
    <div class="main-header-custom">
        <div class="row" style="">
            <div class="row row-title">
                <div class="col-md-12">
                    <h2 class="box-title" style="color: #777777e3;"><i class="fa fa-user-md"></i><b>  Usuários</b></h2>
                </div>
            </div>
        </div>
        <div class="box-body box-pad">
            <div id='alert' class="alert " style="display: none;"></div>
            <div class="row mobile">
                <div class="col-md-6">
                    {!! Form::open(['action' => ('UsuarioController@index'), 'id' => 'form', 'method' => 'GET']) !!}
                    <div class="col-md-8 padding-none">
                        <div class="input-group">
                            {!! Form::text('filter', null, ['class' => 'form-control form-control-custom', 'placeholder' => 'Filtrar...']) !!}
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat btn_icon_filter btn-block btn-primary-custom"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                            </span>
                            <span class="input-group-btn">
                              <a href="{{url('usuario')}}" class="btn btn-primary btn-flat btn_icon_filter btn-primary-custom marginleft pull-left"><i class="fa fa-eraser"></i></a>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-4 col-filter">
                    <button class="col-md-4 btn btn-primary btn-flat btn-block  btn-primary-custom" onclick="inserirUsuario();"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th style="width: 10%; text-align: center;">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usuarios as $row)
                                            <tr>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td style="text-align: center;">
                                                    <button type="button" class="btn btn-primary btn-xs btn-flat btn-primary-custom-no-border" title="Editar" onclick="editarUsuario('{{$row->id}}')">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-xs btn-flat btn-danger-custom-no-border" title="Editar" onclick="deletarUsuario('{{ $row->id }}', '{{$row->name}}')">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-9 skin-pattern">
                                {!! $usuarios->render(); !!}
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <br/>
                                Mostrando {!! $usuarios->firstItem() !!} a {!! $usuarios->lastItem() !!}
                                de {!! $usuarios->total() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-usuario', 'idContent' => 'content-modal-usuario'])
@stop

@section('scripts-footer')
    <script src=" {{ asset('js/app/usuario.js') }} "></script>
@stop