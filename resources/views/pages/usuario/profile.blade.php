@extends('layouts.default')

@section('content')
    @if(isset($paciente))
        {!! Form::model($paciente, ['action' => ('PacienteController@store'), 'id' => 'form-edit-paciente', 'files' => true]) !!}
    @else
        {!! Form::open(['action' => ('PacienteController@store'), 'id' => 'form-create-paciente', 'files' => true]) !!}
    @endif
    {!! Form::hidden('id', isset($paciente) ? $paciente->id : null) !!}
    {!! Form::hidden('user_id', isset($user) ? $user->id : null) !!}
    <input type="hidden" value="{{session('type')}}" name="response_type" />
    <input type="hidden" value="{{session('message')}}" name="response_message" />
    <input type="hidden" value="{{session('redirect')}}" name="response_redirect" />
    <div class="container bootstrap snippet">
        <div class="row">
            <div class="col-sm-10"><h1>{{Auth::user()->name}}</h1></div>
        </div>
        <fieldset class="fieldset-custom">
            <legend>Dados do Usuario</legend>
            <div class="box-body" style="padding-bottom: 15px;">
                <div class="col-sm-3"><!--left col-->
                    <div class="text-center">
                        <img src="{{isset($user->image) ? asset('storage/users/'.$user->image) : 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png'}}" class="avatar img-circle img-thumbnail img-profile" alt="avatar">
                        <h6>Carregar Foto...</h6>
                        {!! Form::file('image-banner', ['accept'=>'image/*', 'multiple'=>false, 'id'=>'image-banner', 'class' => 'text-center center-blox file-upload']) !!}
                        {{--<input type="file" id="image-banner" class="text-center center-block file-upload">--}}
                    </div></hr><br>
                </div>
                <div class="row">
                    <div class="col-md-6  {{ isset(session('error')['name']) ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Nome') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['name']) ? session('error')['name'][0] : '' ]) !!}
                    </div>
                    <div class="col-md-6  {{ isset(session('error')['email']) ? 'has-error' : '' }}">
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
                </div>
            </div>
        </fieldset>
    </div>
    <div class="box" style="margin-top: 10px;">
        <fieldset class="fieldset-custom">
            <legend>Dados do Paciente</legend>
            <div class="box-body" style="padding-bottom: 15px;">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group  {{ isset(session('error')['numero_paciente']) ? 'has-error' : '' }}">
                            {!! Form::label('numero_paciente', 'Nº Paciente', ['class' => 'required']) !!}
                            {!! Form::text('numero_paciente', null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['numero_paciente']) ? session('error')['numero_paciente'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['data_nascimento']) ? 'has-error' : '' }}">
                            {!! Form::label('data_nascimento', 'Data Nascimento', ['class' => 'required']) !!}
                            {!! Form::date('data_nascimento', null, ['id' => 'datefield', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['data_nascimento']) ? session('error')['data_nascimento'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ isset(session('error')['nome_pai']) ? 'has-error' : '' }}">
                            {!! Form::label('nome_pai', 'Nome Pai', ['class' => 'required']) !!}
                            {!! Form::text('nome_pai', null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['nome_pai']) ? session('error')['nome_pai'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ isset(session('error')['nome_mae']) ? 'has-error' : '' }}">
                            {!! Form::label('nome_mae', 'Nome Mãe', ['class' => 'required']) !!}
                            {!! Form::text('nome_mae', null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['nome_mae']) ? session('error')['nome_mae'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['cpf']) ? 'has-error' : '' }}">
                            {!! Form::label('cpf', 'CPF', ['class' => 'required']) !!}
                            {!! Form::text('cpf', null, ['class' => 'form-control', 'id' => 'cpf', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['cpf']) ? session('error')['cpf'][0] : '' ]) !!}
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
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('bairro', 'Bairro', ['class' => 'required']) !!}
                            {!! Form::text('bairro', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('numero', 'Numero', ['class' => 'required']) !!}
                            {!! Form::number('numero', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group {{ isset(session('error')['uf_id']) ? 'has-error' : '' }}">
                            {!! Form::label('uf_id', 'Estado', ['class' => 'required']) !!}
                            {!! Form::select('uf_id', $estados, null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => isset(session('error')['uf_id']) ? session('error')['uf_id'][0] : '' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('cidade', 'Cidade', ['class' => 'required']) !!}
                            {!! Form::text('cidade', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
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
        </fieldset>
    </div>
    <div class="box" style="margin-top: 10px;">
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
    <div class="box" style="margin-top: 10px;">
        <fieldset class="fieldset-custom" style="padding: 6px;">
            <a href="{{url('usuario/profile') }}" style="margin-left: 5px;margin-top: 4px;" class="btn btn-default pull-left btn-flat"><i class="glyphicon glyphicon-remove"></i>&nbsp; Cancelar</a>
            <button type="submit" style="margin-left: 5px;margin-top: 4px;" class="btn btn-success margin-right-send button-send"><i class="fa fa-send"></i> Salvar</button>
        </fieldset>
    </div>
    {!! Form::close() !!}
@stop

@section('scripts-footer')
    <script src=" {{ asset('js/app/usuario.js') }} "></script>
@stop
