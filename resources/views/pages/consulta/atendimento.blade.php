@extends('layouts.default')

@section('content')


    <div class="main-header-custom">
        <div class="row" style="">
            <div class="row row-title">
                <div class="col-md-12">
                    <h2 class="box-title" style="color: #777777e3;"><i class="fas fa-briefcase-hospital"></i><b>  Atendimento</b></h2>
                </div>
            </div>
        </div>
        <div class="box-body box-pad">
            <div id='alert' class="alert " style="display: none;"></div>
            <div class="row mobile">
                <div class="col-md-6">
                    {!! Form::open(['action' => ('ConsultaController@index'), 'id' => 'form', 'method' => 'GET']) !!}
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
            </div>
        </div>
    </div>
    {!! Form::open(['action' => ('ConsultaController@sendEmailConsulta'), 'id' => 'form-delete-consulta', 'method' => 'POST']) !!}
        {!! Form::hidden('id_consulta', null, ['id' => 'id_consulta']) !!}
        {!! Form::hidden('paciente_id', null, ['id' => 'id_paciente']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                @if(count($consultas) == 0)
                                    <h2 style="text-align: center">Nenhuma consulta marcada para hoje</h2>
                                @else
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
                                        <th>Status</th>
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
                                            <td>{{$row->compareceu == true ? "Compareceu" : "Não chegou"}}</td>
                                            <td>
                                                <button type="button" class="btn btn-cust-primary btn-xs btn-flat"
                                                        onclick="compareceu('{{ $row->id }}', '{{$row->paciente}}', '{{$row->paciente_id}}')" data-toggle="tooltip"
                                                        title="Compareceu"><i style="color: green;" class="glyphicon glyphicon-thumbs-up"></i>&nbsp;
                                                </button>
                                                <button type="button" class="btn btn-cust-danger btn-xs btn-flat"
                                                        id="enviar" onclick="naocompareceu('{{ $row->id }}', '{{$row->paciente}}', '{{$row->paciente_id}}')"
                                                        data-toggle="tooltip" title="Não Compareceu"><i
                                                            class="glyphicon glyphicon-thumbs-down"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                                @endif
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
    {!! Form::close() !!}
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/app/consulta.js') }}"></script>
@stop