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
        <div class="col-md-6 alignchart" style="margin-left: 15px;margin-top: 20px;background: #ffffff; -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);">
            <h3 style="margin-left: 90px; position: relative;   font-family: 'Source Sans Pro',sans-serif;text-transform: uppercase;">Consultas com {{validateLogin(['PACIENTE']) ? 'Médicos' : 'Pacientes'}}</h3>
            <div id="pie"></div>
        </div>
        <div style="width: 47%;margin-left: 8px;">
            <div class="alignchart" style="height: 95%;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);">
                    <h3 class="align-font" style="padding-top: 20px;">Total de Consultas</h3>
                    <h2 class="align-font">{{\Auth::user()->name}}, Você tem no total</h2>
                    <h1 class="align-number">{{$totalConsultas}}</h1>
                    <h1 class="align-font">Consulta (s)</h1>
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
    <script>
        $(document).ready(function () {
            informativo();
        });
    </script>

@stop


