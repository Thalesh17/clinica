@extends('layouts.default')

@section('content')


    <div class="main-header-custom">
        <div class="row" style="">
            <div class="row row-title">
                <div class="col-md-12">
                    <h2 class="box-title" style="color: #777777e3;"><i class="fa fa-users"></i><b>  Pacientes</b></h2>
                </div>
            </div>
        </div>
        <div class="box-body box-pad">
            <div id='alert' class="alert " style="display: none;"></div>
            <div class="row mobile">
                <div class="col-md-6">
                    {!! Form::open(['action' => ('PacienteController@index'), 'id' => 'form', 'method' => 'GET']) !!}
                    <div class="col-md-8 padding-none">
                        <div class="input-group">
                            {!! Form::text('filtro', null, ['class' => 'form-control form-control-custom', 'placeholder' => 'Filtrar...']) !!}
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat btn_icon_filter btn-block btn-primary-custom"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                            </span>
                            <span class="input-group-btn">
                              <a href="{{url('paciente')}}" class="btn btn-primary btn-flat btn_icon_filter btn-primary-custom marginleft pull-left"><i class="fa fa-eraser"></i></a>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-4 col-filter">
                    <a href="{{url('paciente/create')}}" class="col-md-4 btn btn-primary btn-flat btn-block  btn-primary-custom"><i class="glyphicon glyphicon-plus"></i> Adicionar</a>
                    {{--<div class="col-xs-11 col-md-4">--}}
                        {{--<button type="button" class="btn btn-primary btn-flat btn-block  btn-primary-custom" onclick="exportarExcel()"><i class="fa fa-file-excel-o"></i>&nbsp; Excel </button>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
    <!------ Include the above in your HEAD tag ---------->
    <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="card card-no-shadow">
            <div class="card-header" role="tab" id="headingTwo">
                <h5 class="mb-0">
                    <a class="collapsed" id="filtro_avancado" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Filtro Avançado
                    </a>
                    <a style="margin-left: 12px;cursor: pointer;" onclick="exportarExcel()"><i class="fa fa-file-excel-o"></i>&nbsp; Excel </a>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="card-block">
                    {!! Form::open(['action' => ('PacienteController@index'), 'id' => 'form-avancado', 'method' => 'GET']) !!}
                    <div class="container-fluid bg-light ">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-1 pt-3">
                                <div class="form-group ">
                                    {!! Form::label('numero_paciente', 'N Paciente') !!}
                                    {!! Form::text('numero_paciente', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div class="col-md-2 pt-3">
                                <div class="form-group ">
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::text('email', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div class="col-md-2 pt-3">
                                <div class="form-group">
                                    {!! Form::label('telefone', 'Telefone') !!}
                                    {!! Form::text('telefone', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div class="col-md-2 pt-3">
                                <div class="form-group">
                                    {!! Form::label('data_nascimento', 'Data Nascimento') !!}
                                    {!! Form::date('data_nascimento', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div class="col-md-2 pt-3">
                                <div class="form-group">
                                    {!! Form::label('cidade', 'Cidade') !!}
                                    {!! Form::text('cidade', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div class="col-md-2 pt-3">
                                <div class="form-group">
                                    {!! Form::label('data_cadastro', 'Data Cadastro') !!}
                                    {!! Form::date('data_cadastro', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div style="margin-top: 18px;">
                                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat btn_icon_filter marginleft btn-primary-custom"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                    </span>
                                    <span class="input-group-btn">
                          <a href="{{url('paciente')}}" class="btn btn-primary btn-flat btn_icon_filter btn-primary-custom marginleft pull-left"><i class="fa fa-eraser"></i></a>
                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="{{session('type')}}" name="response_type" />
    <input type="hidden" value="{{session('message')}}" name="response_message" />
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
                                        <th>Nº Paciente</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Telefone</th>
                                        <th>Data Nascimento</th>
                                        <th>Cidade</th>
                                        <th>Bairro</th>
                                        <th>Data Cadastro</th>
                                        <th style="width: 12%; text-align: center;">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pacientes as $row)
                                        <tr>
                                            <td>{{$row->numero_paciente}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->email}}</td>
                                            <td>{{$row->telefone}}</td>
                                            <td>{{dateToView($row->data_nascimento)}}</td>
                                            <td>{{$row->cidade}}</td>
                                            <td>{{$row->bairro}}</td>
                                            <td>{{dateToView($row->created_at)}}</td>
                                            <td>
                                                <button class="btn btn-cust-success btn-xs btn-flat" onclick="visualizar({{$row->id}})" data-toggle="tooltip" title="Visualizar Paciente {{$row->name}}"><i class="fa fa-search"></i>&nbsp;</button>&nbsp;</button>
                                                <button class="btn btn-cust-primary btn-xs btn-flat" onclick="editar({{$row->id}})" data-toggle="tooltip" title="Editar"><i class="glyphicon glyphicon-pencil"></i>&nbsp;</button>
                                                <button class="btn btn-cust-danger btn-xs btn-flat" onclick="deletar('{{ $row->id }}', '{{$row->name}}')" data-toggle="tooltip" title="Excluir"><i class="glyphicon glyphicon-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-paciente', 'idContent' => 'content-modal-paciente'])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-visualizar', 'idContent' => 'content-modal-visualizar'])
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/app/paciente.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app/funcoesJavaScript.js') }}"></script>
@stop