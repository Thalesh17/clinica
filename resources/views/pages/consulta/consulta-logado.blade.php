@extends('layouts.default')

@section('content')


    <div class="main-header-custom custom">
        <div class="row" style="">
            <div class="row row-title">
                <div class="col-md-12">
                    <h2 class="box-title" style="color: #777777e3;"><i class="fas fa-user"></i>  <b>Suas Consultas</b></h2>
                </div>
            </div>
        </div>
        <div class="box-body box-pad">
            <div id='alert' class="alert " style="display: none;"></div>
            <div class="row mobile">
                <div class="col-md-6">
                    {!! Form::open(['action' => ('ConsultaController@consultasPaciente'), 'id' => 'form', 'method' => 'GET']) !!}
                    <div class="col-md-8 padding-none">
                        <div class="input-group">
                            {!! Form::text('filtro', null, ['class' => 'form-control form-control-custom', 'placeholder' => 'Filtrar...']) !!}
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat btn_icon_filter btn-block btn-primary-custom"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                            </span>
                            <span class="input-group-btn">
                              <a href="{{url('consulta')}}" class="btn btn-primary btn-flat btn_icon_filter btn-primary-custom marginleft pull-left"><i class="fa fa-eraser"></i></a>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                @if(validateLogin(['PACIENTE']))
                    <div class="col-md-4 col-filter">
                        <button class="col-md-4 btn btn-primary btn-flat btn-block  btn-primary-custom" onclick="adicionar();"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                    </div>
                @endif
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
                    {!! Form::open(['action' => ('ConsultaController@consultasPaciente'), 'id' => 'form-avancado', 'method' => 'GET']) !!}
                    <div class="container-fluid bg-light ">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-2 pt-3">
                                <div class="form-group ">
                                    {!! Form::label('paciente', 'Paciente') !!}
                                    {!! Form::text('paciente', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div class="col-md-2 pt-3">
                                <div class="form-group ">
                                    {!! Form::label('medico', 'Médico') !!}
                                    {!! Form::text('medico', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div class="col-md-2 pt-3">
                                <div class="form-group">
                                    {!! Form::label('especialidade', 'Especialidade') !!}
                                    {!! Form::select('especialidade', $especialidade, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2 pt-3">
                                <div class="form-group">
                                    {!! Form::label('sintoma', 'Sintoma') !!}
                                    {!! Form::text('sintoma', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div class="col-md-2 pt-2">
                                <div class="form-group">
                                    {!! Form::label('data_consulta', 'Data Consulta') !!}
                                    {!! Form::date('data_consulta', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div class="pt-2" style="padding-right: 12px;">
                                <div class="form-group">
                                    {!! Form::label('horario', 'Horário') !!}
                                    {!! Form::time('horario', null,(['class' => 'form-control'])) !!}
                                </div>
                            </div>
                            <div style="margin-top: 18px;">
                                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat btn_icon_filter marginleft btn-primary-custom"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                    </span>
                                    <span class="input-group-btn">
                          <a href="{{url('consulta/usuario')}}" class="btn btn-primary btn-flat btn_icon_filter btn-primary-custom marginleft pull-left"><i class="fa fa-eraser"></i></a>
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
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover dataTable" style="white-space: nowrap;">
                                    <thead>
                                    <tr class="">
                                        <th style="width: 17%;">Paciente</th>
                                        <th style="width: 15%;">Médico</th>
                                        <th>Especialidade</th>
                                        <th>Sintoma</th>
                                        <th>Data Consulta</th>
                                        <th>Horario</th>
                                        <th style="width: 16%;">Observação</th>
                                        <th style="width: 7%;">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($consultas as $row)
                                        <tr>
                                            <td>{{$row->paciente}}</td>
                                            <td>{{$row->medico}}</td>
                                            <td>{{$row->especialidade}}</td>
                                            <td>{{$row->sintoma}}</td>
                                            <td>{{dateToView($row->data_consulta)}}</td>
                                            <td>{{substr($row->data_consulta, 10,14)}}</td>
                                            <td>{{$row->observacao}}</td>
                                            <td style="text-align: center">
                                                <button class="btn btn-cust-primary btn-xs btn-flat {{dateToView($row->data_consulta) <= date('d/m/Y') ? "none-display" : ''}}"
                                                        onclick="editar({{$row->id}})" data-toggle="tooltip"
                                                        title="Editar"><i class="glyphicon glyphicon-pencil"></i>&nbsp;
                                                </button>
                                                <button class="btn btn-cust-danger btn-xs btn-flat"
                                                        onclick="deletar('{{ $row->id }}', '{{$row->paciente}}', '{{$row->medico}}')"
                                                        data-toggle="tooltip" title="Excluir"><i
                                                            class="glyphicon glyphicon-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-9 skin-pattern">
                                        {!! $consultas->render(); !!}
                                    </div>
                                    <div class="col-md-3" style="text-align: right;">
                                        <br/>
                                        Mostrando {!! $consultas->firstItem() !!} a {!! $consultas->lastItem() !!}
                                        de {!! $consultas->total() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-consulta', 'idContent' => 'content-modal-consulta'])
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/app/consulta.js') }}"></script>
@stop