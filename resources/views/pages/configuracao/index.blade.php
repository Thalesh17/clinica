@extends('layouts.default')

@section('styles-header')

    <style>
        .fieldset-custom{
            min-height: 120px;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header page-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="box-title"> <i class="fa fa-cog" aria-hidden="true"></i> Configuração</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($configuracao))
        {!! Form::model($configuracao, ['action' => ('ConfiguracaoController@store'), 'id' => 'form-configuracao', 'files' => true]) !!}
    @else
        {!! Form::open(['action' => ('ConfiguracaoController@store'), 'id' => 'form-configuracao', 'files' => true]) !!}
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header page-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="box-title">Dados</h4>
                        </div>
                    </div>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    {!! Form::hidden('uuid', null) !!}
                    <div class="row">
                        <div class="col-md-2">
                            {!! Form::label('cnpj', 'CNPJ:') !!}
                            {!! Form::text('cnpj', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('razao_social', 'Razão Social:') !!}
                            {!! Form::text('razao_social', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('nome_fantasia', 'Nome Fantasia:') !!}
                            {!! Form::text('nome_fantasia', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::label('sigla', 'Sigla:') !!}
                            {!! Form::text('sigla', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="web" style="clear: both;"></div>
                    <div class="row">
                        <div class="col-md-2">
                            {!! Form::label('insc_estadual', 'Inscrição Estadual:') !!}
                            {!! Form::text('insc_estadual', null, ['class' => 'form-control', 'onkeypress' => 'return somenteNumeros(event)', 'maxlength' => 45]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('email', 'E-mail:') !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'maxlength' => 45]) !!}
                        </div>

                    </div>
                    <div class="web" style="clear: both;"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset class="fieldset-custom">
                                <legend>Importar Logo</legend>
                                @if($imageLogo)
                                    <div class="img-preview">
                                        <img src="{{ asset($imageLogo)}}" />
                                    </div>
                                @endif
                                <div class="file-upload btn btn-primary">
                                    <span>Escolher arquivos <i class="fa fa-cloud-upload"></i></span>
                                    {!! Form::file('image', ['accept'=>'image/*', 'multiple'=>false, 'id'=>'image']) !!}
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="fieldset-custom">
                                <legend>Importar Banner</legend>
                                @if($imageBanner)
                                    <div class="img-preview">
                                        <img src="{{ asset($imageBanner)}}" />
                                    </div>
                                @endif
                                <div class="file-upload btn btn-primary">
                                    <span>Escolher arquivos <i class="fa fa-cloud-upload"></i></span>
                                    {!! Form::file('image_banner', ['accept'=>'image/*', 'multiple'=>false, 'id'=>'image-banner']) !!}
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header page-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="box-title">Endereço</h4>
                        </div>
                    </div>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-9">
                            {!! Form::label('logradouro', 'Logradouro:') !!}
                            {!! Form::text('logradouro', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
                        </div>
                        <div class="col-md-1">
                            {!! Form::label('numero', 'Nº:') !!}
                            {!! Form::text('numero', null, ['class' => 'form-control', 'id' => 'numero']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::label('cep', 'CEP:') !!}
                            {!! Form::text('cep', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="web" style="clear: both;"></div>
                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::label('bairro', 'Bairro:') !!}
                            {!! Form::text('bairro', null, ['class' => 'form-control', 'maxlength' => 50]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('complemento', 'Complemento:') !!}
                            {!! Form::text('complemento', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('cidade', 'Cidade:') !!}
                            {!! Form::text('cidade', null, ['class' => 'form-control', 'maxlength' => 50]) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::label('uf_uuid', 'UF:') !!}
                            {!! Form::select('uf_uuid', $estados  , null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="web" style="clear: both;"></div>
                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::label('telefone', 'Telefone:') !!}
                            {!! Form::text('telefone', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('celular', 'Celular:') !!}
                            {!! Form::text('celular', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="web" style="clear: both;"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Configurações de E-mail</legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::label('email_host', 'E-mail Host:') !!}
                                        {!! Form::text('email_host', env('MAIL_HOST'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        {!! Form::label('port_host', 'Porta:') !!}
                                        {!! Form::text('port_host', env('MAIL_PORT'), ['class' => 'form-control', 'onkeypress' => 'return somenteNumeros(event)']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::label('email_user', 'E-mail:') !!}
                                        {!! Form::text('email_user', env('MAIL_USERNAME'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-2">
                                        {!! Form::label('password_host', 'Senha:') !!}
                                        <input type="password" class="form-control" name="password_host" value="{{env('MAIL_PASSWORD')}}">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header page-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="box-title">Skins</h4>
                        </div>
                    </div>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    {!! Form::hidden('skin', null) !!}
                    <div class="row">
                        <ul class="list-unstyled clearfix">
                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-blue" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px; background: #367fa9"></span>
                                            <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 13px;"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #222d32"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin">Blue</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-black" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                            <span style="display:block; width: 20%; float: left; height: 13px; background: #fefefe"></span>
                                            <span style="display:block; width: 80%; float: left; height: 13px; background: #fefefe"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #222"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin">Black</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-purple" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px;" class="bg-purple-active"></span>
                                            <span class="bg-purple" style="display:block; width: 80%; float: left; height: 13px;"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #222d32"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin">Purple</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-green" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px;" class="bg-green-active"></span>
                                            <span class="bg-green" style="display:block; width: 80%; float: left; height: 13px;"></span></div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #222d32"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin">Green</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-red" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px;" class="bg-red-active"></span>
                                            <span class="bg-red" style="display:block; width: 80%; float: left; height: 13px;"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #222d32"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin">Red</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-yellow" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px;" class="bg-yellow-active"></span>
                                            <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 13px;"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #222d32"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin">Yellow</p>
                                </li>
                            </div>
                            <div class="web" style="clear: both;"></div>
                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-blue-light" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px; background: #367fa9"></span>
                                            <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 13px;"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #f9fafc"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-black-light" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                            <span style="display:block; width: 20%; float: left; height: 13px; background: #fefefe"></span>
                                            <span style="display:block; width: 80%; float: left; height: 13px; background: #fefefe"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #f9fafc"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-purple-light" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px;" class="bg-purple-active"></span>
                                            <span class="bg-purple" style="display:block; width: 80%; float: left; height: 13px;"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #f9fafc"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-green-light" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px;" class="bg-green-active"></span>
                                            <span class="bg-green" style="display:block; width: 80%; float: left; height: 13px;"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #f9fafc"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout" >
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-red-light" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px;" class="bg-red-active"></span>
                                            <span class="bg-red" style="display:block; width: 80%; float: left; height: 13px;"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #f9fafc"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
                                </li>
                            </div>

                            <div class="col-md-2 change-skin-layout">
                                <li style="float:left; width: 60%;">
                                    <a href="javascript:void(0)" data-skin="skin-yellow-light" style="height: 70px;display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 13px;" class="bg-yellow-active"></span>
                                            <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 13px;"></span>
                                        </div>
                                        <div>
                                            <span style="display:block; width: 20%; float: left; height: 57px; background: #f9fafc"></span>
                                            <span style="display:block; width: 80%; float: left; height: 57px; background: #f4f5f7"></span>
                                        </div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Yellow Light</p>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header page-header">
                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" class="btn btn-default btn-flat btn-block btn-default-custom" id="fechar"><i class="fa fa-close"></i> Cancelar </button>
                        </div>
                        <div class="col-md-2 col-md-offset-8">
                          <button type="submit" class="btn btn-success btn-flat btn-block btn-success-custom" id="salvar-configuracao"><i class="fa fa-check"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/app/configuracao.js') }}"></script>
@stop