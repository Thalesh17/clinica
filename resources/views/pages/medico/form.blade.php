@extends('layouts.default')

@section('content')
    <div class="main-header-custom">
        <div class="row" style="">
            <div class="row row-title">
                <div class="col-md-12">
                    <h2 class="box-title" style="color: #777777e3;"><i class="fa fa-user-md"></i><b>  Cadastrar Médico</b></h2>
                </div>
            </div>
        </div>
    </div>
    @if(isset($medico))
        {!! Form::model($medico, ['action' => ('MedicoController@store'), 'id' => 'form-edit-medico','files' => true]) !!}
    @else
        {!! Form::open(['action' => ('MedicoController@store'), 'id' => 'form-create-medico','files' => true]) !!}
    @endif
    {!! Form::hidden('id', null) !!}
    <input type="hidden" value="{{session('type')}}" name="response_type" />
    <input type="hidden" value="{{session('message')}}" name="response_message" />
    <input type="hidden" value="{{session('redirect')}}" name="response_redirect" />
    <div class="box" style="margin-top: 14px;padding: 12px;">
        <fieldset class="fieldset-custom">
            <legend>Dados do Usuario</legend>
            <div class="box-body" style="padding-bottom: 15px;">
                <div class="col-sm-3"><!--left col-->
                    <div class="text-center">
                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail img-profile" alt="avatar">
                        <h6>Upload a different photo...</h6>
                        <input type="file" class="text-center center-block file-upload">
                    </div></hr><br>
                </div>
                <div class="row">
                    <div class="col-md-6  {{ isset(session('error')['name']) ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Nome') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['name']) ? session('error')['name'][0] : '' ]) !!}
                    </div>
                    <div class="col-md-6 {{ isset(session('error')['email']) ? 'has-error' : '' }}">
                        <div class="form-group">
                            {!! Form::label('Email', 'Email', ['class' => 'required']) !!}
                            {!! Form::text('email', null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['email']) ? session('error')['email'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6  {{ isset(session('error')['password']) ? 'has-error' : '' }}">
                        {!! Form::label('password', 'Senha:') !!}
                        {!! Form::password('password', ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['password']) ? session('error')['password'][0] : '' ]) !!}
                    </div>
                    <div class="col-md-6  {{ isset(session('error')['repeat-password']) ? 'has-error' : '' }}">
                        {!! Form::label('repeat-password', 'Confirmar Senha:') !!}
                        {!! Form::password('repeat-password', ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['repeat-password']) ? session('error')['repeat-password'][0] : '' ]) !!}
                    </div>
                    </br>
                    <div class="col-md-6  {{ isset(session('error')['horario_inicio']) ? 'has-error' : '' }}">
                        {!! Form::label('horario_inicio', 'Horario Inicio:') !!}
                        {!! Form::time('horario_inicio',null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['horario_inicio']) ? session('error')['horario_inicio'][0] : '' ]) !!}
                    </div>
                    <div class="col-md-6  {{ isset(session('error')['horario_termino']) ? 'has-error' : '' }}">
                        {!! Form::label('horario_termino', 'Horario Fim:') !!}
                        {!! Form::time('horario_termino', null,['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['horario_termino']) ? session('error')['horario_termino'][0] : '' ]) !!}
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="box" style="margin-top: 14px;padding: 12px;">
        <fieldset class="fieldset-custom">
            <legend>Dados Pessoais</legend>
            <div class="box-body" style="padding-bottom: 15px;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ isset(session('error')['data_nascimento']) ? 'has-error' : '' }}">
                            {!! Form::label('data_nascimento', 'Data Nascimento', ['class' => 'required']) !!}
                            {!! Form::date('data_nascimento', null, ['id' => 'datefield', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['data_nascimento']) ? session('error')['data_nascimento'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ isset(session('error')['crm']) ? 'has-error' : '' }}">
                            {!! Form::label('crm', 'CRM', ['class' => 'required']) !!}
                            {!! Form::text('crm', null, ['class' => 'form-control', 'id' => 'crm', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['crm']) ? session('error')['crm'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['uf_id']) ? 'has-error' : '' }}">
                            {!! Form::label('especialidade_id', 'Especialidade', ['class' => 'required']) !!}
                            {!! Form::select('especialidade_id', $especialidade, null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['especialidade_id']) ? session('error')['especialidade_id'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['rg']) ? 'has-error' : '' }}">
                            {!! Form::label('rg', 'RG', ['class' => 'required']) !!}
                            {!! Form::text('rg', null, ['class' => 'form-control', 'id' => 'rg', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['rg']) ? session('error')['rg'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('endereco', 'Endereço', ['class' => 'required']) !!}
                            {!! Form::text('endereco', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('numero', 'Numero', ['class' => 'required']) !!}
                            {!! Form::number('numero', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('bairro', 'Bairro', ['class' => 'required']) !!}
                            {!! Form::text('bairro', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('cidade', 'Cidade', ['class' => 'required']) !!}
                            {!! Form::text('cidade', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['uf_id']) ? 'has-error' : '' }}">
                            {!! Form::label('uf_id', 'Estado', ['class' => 'required']) !!}
                            {!! Form::select('uf_id', $estados, null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['uf_id']) ? session('error')['uf_id'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('nacionalidade', 'Nacionalidade', ['class' => 'required']) !!}
                            {!! Form::text('nacionalidade', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['sexo_id']) ? 'has-error' : '' }}">
                            {!! Form::label('sexo_id', 'Sexo', ['class' => 'required']) !!}
                            {!! Form::select('sexo_id', $sexo, null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['sexo_id']) ? session('error')['sexo_id'][0] : '' ]) !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['tipo_sanguineo_id']) ? 'has-error' : '' }}">
                            {!! Form::label('tipo_sanguineo_id', 'Tipo Sanguíneo', ['class' => 'required']) !!}
                            {!! Form::select('tipo_sanguineo_id', $tipoSanguineo, null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['tipo_sanguineo_id']) ? session('error')['tipo_sanguineo_id'][0] : '' ]) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('referencia', 'Referencia', ['class' => 'required']) !!}
                            {!! Form::text('referencia', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
                    {{--<div class="col-md-4">--}}
                        {{--<fieldset class="fieldset-custom" style="height: 300px;">--}}
                            {{--<legend>Importar Perfil</legend>--}}
                            {{--<div class="image-upload-banner" style="">--}}
                                {{--@if(isset($user) && isset($user->image))--}}
                                    {{--<span title="Deletar Banner" data-toggle="tooltip" class="fa fa-times delete-thumb delete-banner" onclick="deletarImagem('{{'banner'}}');"></span>--}}
                                    {{--<div>--}}
                                        {{--<img class="image-banner-esconder" src="{{asset('storage/users/'.$user->image)}}" alt="{{ $user->name }}">--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                            {{--<div class="file-upload btn btn-primary" style="margin-top: -45px;    width: 100%;">--}}
                                {{--{!! Form::file('image-banner', ['accept'=>'image/*', 'multiple'=>false, 'id'=>'image-banner']) !!}--}}
                            {{--</div>--}}
                        {{--</fieldset>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-8">--}}
                        {{--<fieldset class="fieldset-custom" style="height: 300px;">--}}
                            {{--<legend>Especialidade</legend>--}}
                            {{--<div class="col-md-12">--}}
                                {{--<div class="row">--}}
                                    {{--<div style="clear: both;"></div>--}}
                                        {{--<div class="col-md-12">--}}
                                            {{--{!! Form::label('', 'Especialidade') !!}--}}
                                            {{--<div class="input-group input-group {{ isset(session('error')['especialidade-select']) ? 'has-error' : '' }}">--}}
                                                {{--{!! Form::select('especialidade-select', $especialidade, null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'id' => 'especialidade-select', 'title' => isset(session('error')['especialidade-select']) ? session('error')['especialidade-select'][0] : '' ]) !!}--}}
                                                {{--<span class="input-group-btn">--}}
                                                {{--{!! Form::button('Incluir', ['class' => 'btn btn-primary btn-flat', 'id' => 'add-especialidade']) !!}--}}
                                            {{--</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--<div class="col-md-12 table-max-height">--}}
                                        {{--<br/>--}}
                                        {{--<table class="table table-hover" id="table-body-especialidade">--}}
                                            {{--<thead>--}}
                                                {{--<th>Nome</th>--}}
                                                {{--<th style="width: 8%; text-align: center;">Ações</th>--}}
                                            {{--</thead>--}}
                                            {{--<tbody></tbody>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</fieldset>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </fieldset>
    </div>
    <div class="box" style="margin-top: 14px;padding: 12px;">
        <fieldset class="fieldset-custom">
            <legend>Contato</legend>
            <div class="box-body" style="padding-bottom: 15px;">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['telefone']) ? 'has-error' : '' }}">
                            {!! Form::label('telefone', 'Telefone', ['class' => 'required']) !!}
                            {!! Form::text('telefone', null, ['class' => 'form-control', 'id' => 'telefone', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['telefone']) ? session('error')['telefone'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['celular']) ? 'has-error' : '' }}">
                            {!! Form::label('celular', 'Celular', ['class' => 'required']) !!}
                            {!! Form::text('celular', null, ['class' => 'form-control', 'id' => 'celular', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['celular']) ? session('error')['celular'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::label('observacao', 'Observação', ['class' => 'required']) !!}
                            {!! Form::text('observacao', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="box" style="margin-top: 14px;padding: 12px;">
        <fieldset class="fieldset-custom" style="padding: 6px;">
            <a href="{{url('paciente') }}" style="margin-left: 5px;margin-top: 4px;" class="btn btn-default pull-left btn-flat"><i class="glyphicon glyphicon-remove"></i>&nbsp; Cancelar</a>
            <button type="submit" style="margin-left: 5px;margin-top: 4px;" class="btn btn-success margin-right-send button-send"><i class="fa fa-send"></i> Salvar</button>
        </fieldset>
    </div>
    {!! Form::close() !!}
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-usuario', 'idContent' => 'content-modal-usuario'])
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/app/config-especialidade.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app/medico.js') }}"></script>
@stop

