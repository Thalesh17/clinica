@extends('layouts.auth')

@section('content')
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-4 col-md-offset-4">--}}
                {{--<div class="logo-login">--}}
                    {{--<a href="{{ url('/') }}">--}}
                        {{--@if(getLogo() != null )--}}
                            {{--<img src="{{ getLogo()[0] }}" class="img-responsive" style="width: 300px;">--}}
                        {{--@else--}}
                            {{--<b> Clinica-JP </b>--}}
                        {{--@endif--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-4 col-md-offset-4">--}}
                {{--<form class="form-horizontal" method="POST" action="{{ route('login') }}">--}}
                    {{--{{ csrf_field() }}--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                                {{--{!! Form::label('email', 'Email:') !!}--}}
                                {{--<div class="input-group">--}}
                                    {{--<span class="input-group-addon"><i class="fa fa-envelope"></i></span>--}}
                                    {{--{!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email', 'required' ,"value" => "{{ old('email') }}"]) !!}--}}
                                {{--</div>--}}
                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
                                {{--{!! Form::label('password', 'Senha:', ['class' => 'text-black']) !!}--}}
                                {{--<div class="input-group">--}}
                                    {{--<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>--}}
                                    {{--{!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'required']) !!}--}}
                                {{--</div>--}}
                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<br />--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12" style="padding: 0;">--}}
                            {{--<button type="submit" class="btn btn-success btn-flat btn-block">--}}
                                {{--Login--}}
                            {{--</button>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4 col-md-offset-3">--}}
                            {{--<a class="btn btn-link btn-link-person" href="{{ route('password.request') }}">--}}
                                {{--Esqueceu sua senha?--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</form>--}}
                {{--<div class="col-md-12" style="padding: 0;">--}}
                    {{--<a href="{{url('user/create')}}" class="btn btn-success btn-flat btn-block">--}}
                        {{--Quero ser um Paciente.--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->


    <html>
    <head>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->
    </head>
    <body id="LoginForm">
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        <input type="hidden" value="{{session('type')}}" name="response_type" />
        <input type="hidden" value="{{session('message')}}" name="response_message" />
        <input type="hidden" value="{{session('redirect')}}" name="response_redirect" />
        {{ csrf_field() }}
        <div class="container">
        <h1 class="form-heading">Clinic-JP</h1>
        <div class="login-form">
            <div class="main-div">
                <div class="panel">
                    <h2>Clinic-JP</h2>
                    <p>Entre com seu e-mail e senha</p>
                </div>

                <form id="Login">

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                        {!! Form::label('email', 'Email:') !!}

                        {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'inputEmail', 'required' ,"value" => "{{ old('email') }}"]) !!}

                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        {!! Form::label('password', 'Senha:') !!}

                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'inputPassword', 'required']) !!}

                    </div>
                    <a class="forgot" href="{{ route('password.request') }}">
                        Esqueceu sua senha?
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>

                </form>
            </div>
        </div></div>
        </div>

    </form>
    </body>
    <script type="text/javascript" src="{{ asset('js/funcoesJavaScript.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/form-error-message.js') }}"></script>
    <script>
        $(document).ready(function () {
            responseType("paciente");
        });

    </script>
    </html>

@endsection
