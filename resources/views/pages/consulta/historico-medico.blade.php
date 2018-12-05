@extends('layouts.default')

@section('content')


    <div class="main-header-custom">
        <div class="row" style="">
            <div class="row row-title">
                <div class="col-md-12">
                    <h2 class="box-title" style="color: #777777e3;"><i class="fas fa-briefcase-hospital"></i><b>  Consultas</b></h2>
                </div>
            </div>
        </div>
        <div class="box-body box-pad">
            <div id='alert' class="alert " style="display: none;"></div>
            <div class="row mobile">
                <div class="col-md-6">
                    {!! Form::open(['action' => ('ConsultaController@historicoMedico'), 'id' => 'form', 'method' => 'GET']) !!}
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
                <div class="col-md-4 col-filter">
                    <button class="col-md-4 btn btn-primary btn-flat btn-block  btn-primary-custom" onclick="adicionar();"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
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
                                        <th>Paciente</th>
                                        <th>Médico</th>
                                        <th>Especialidade</th>
                                        <th>Sintoma</th>
                                        <th>Data Consulta</th>
                                        <th>Horario</th>
                                        <th>Observação</th>
                                        <th>Ações</th>
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
                                            <td>
                                                <button class="btn btn-cust-primary btn-xs btn-flat"
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