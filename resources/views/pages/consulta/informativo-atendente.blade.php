@extends('layouts.default')
@section('styles-header')
    <style>
        .chart{
            font: 13px sans-serif;
            font-weight: bold;
        }

        .c3-chart-arcs-title {
            font: 13px sans-serif;
            font-weight: bold;
        }

        .text-graphic{
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
        }

        .alignchart{
            margin-left: 15px;
            margin-top: 20px;
            background: #ffffff;
        }

        .align-number{
            text-align: center;
            font-size: 134px;
        }

        .align-font{
            font-family: 'Source Sans Pro',sans-serif;
            text-transform: uppercase;
            text-align: center;
        }
    </style>
@stop

@section('content')
    {!! Form::open(['action' => ('ConsultaController@informativoIndex'), 'id' => 'form-informativo', 'method' => 'GET']) !!}
    <div class="main-header main-header-custom">
        <div class="row row-title">
            <div class="col-md-12">
                <p class="box-title" style="color: #777777e3;"><b>Informativos</b></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div style="width: 47%;margin-left: 8px;">
            <div class="alignchart" style="height: 95%;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);">
                <h3 class="align-font" style="padding-top: 20px;">Total de Médicos</h3>
                <h2 class="align-font">{{\Auth::user()->name}}, na clínica temos</h2>
                <h1 class="align-number">{{$totalMedicos}}</h1>
                <h1 class="align-font">Médico (s)</h1>
            </div>
        </div>
        <div style="width: 47%;margin-left: 8px;">
            <div class="alignchart" style="height: 95%;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);">
                <h3 class="align-font" style="padding-top: 20px;">Total de Pacientes</h3>
                <h2 class="align-font">{{\Auth::user()->name}}, na clínica temos</h2>
                <h1 class="align-number">{{$totalPacientes}}</h1>
                <h1 class="align-font">Paciente(s)</h1>
            </div>
        </div>
    </div>
    </br>
    <div class="main-header main-header-custom">
        <div class="row row-title">
            <div class="col-md-12">
                <p class="box-title" style="color: #777777e3;"><b>Consultas(Dia)</b></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div id="sed" style="background: #ffffff;"></div>
            </div>
        </div>
    </div>
    </br>

    <div class="main-header main-header-custom">
        <div class="row row-title">
            <div class="col-md-12">
                <p class="box-title" style="color: #777777e3;"><b>Consultas(Ano)</b></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div id="cano" style="background: #ffffff;"></div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop
@section('scripts-footer')
    <script src=" {{ asset('js/app/consulta.js') }}"></script>
    {{--<script>--}}
        {{--$(document).ready(function () {--}}
            {{--informativo();--}}
        {{--});--}}
    {{--</script>--}}
    {{--<script>--}}
        {{--function informativo() {--}}
            {{--$.ajax({--}}
                {{--type: "GET",--}}
                {{--url: urlBase + "consulta/informativo/atendente",--}}
                {{--success : function (data){--}}
                    {{--if(data.length == 0){--}}
                        {{--$("#chart").html('<div class="informative"><h3 class="msg-alert-filter text-center"><i class="fa fa-calendar-times-o"></i> Não foi encontrado nenhum dado de informativo.</h3></div>')--}}
                        {{--return;--}}
                    {{--}--}}
                    {{--data.forEach(function(e) {--}}
                        {{--info.push(e.user);--}}
                        {{--data1[e.user] = e.count;--}}
                    {{--});--}}
                    {{--var chart = c3.generate({--}}
                        {{--bindto: '#pie',--}}
                        {{--size:{--}}
                            {{--height: 300,--}}
                        {{--},--}}
                        {{--data: {--}}
                            {{--json: [ data1 ],--}}
                            {{--keys: {--}}
                                {{--value: info,--}}
                            {{--},--}}
                            {{--type:'pie'--}}
                        {{--},--}}
                        {{--legend: {--}}
                            {{--position: 'right'--}}
                        {{--},--}}
                        {{--color: {--}}
                            {{--pattern: ['#D2691E','#FF0000', '#00FF00'],--}}
                        {{--},--}}
                        {{--tooltip: {--}}
                            {{--format: {--}}
                                {{--value: function(value, ratio, id) {--}}
                                    {{--return value;--}}
                                {{--}--}}
                            {{--}--}}
                        {{--},--}}
                    {{--});--}}
                {{--} ,--}}
                {{--error : function (data) {--}}

                {{--}--}}
            {{--}).fail(function(resposta) {--}}
                {{--if(resposta.status == 401){--}}
                    {{--swal("Funções", "Sem permissão para acessar essa funcionalidade." , "error");--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}
    {{--</script>--}}

@stop


