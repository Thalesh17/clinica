<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{$medico->name}}</h4>
</div>
<div class="modal-body">
    <div id='alert-modal' class="alert" style="display: none;"></div>
    <div class="col-md-4" style="position: absolute">
        <fieldset class="fieldset-custom field-modelo-show">
            {{--<legend>Foto</legend>--}}
            <img src="{{isset($user->image) ? asset('storage/users/'.$user->image) : 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png'}}" width="150px" height="150px" style="margin-top: 3px;">
        </fieldset>
    </div>
    <div class="row">
        <div class="col-md-4">
            {!! Form::label('name', 'N Paciente', ['class' => 'required']) !!}
            <p>{{$medico->name}}</p>
        </div>
        <div class="col-md-4">
            {!! Form::label('name', 'Data Nascimento', ['class' => 'required']) !!}
            <p>{{dateToView($medico->data_nascimento)}}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            {!! Form::label('name', 'Nome Pai', ['class' => 'required']) !!}
            <p>{{$medico->especialidade}}</p>
        </div>

        <div class="col-md-4">
            {!! Form::label('name', 'Nome Pai', ['class' => 'required']) !!}
            <p>{{$medico->crm}}</p>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            {!! Form::label('name', 'Cidade', ['class' => 'required']) !!}
            <p>{{($medico->cidade)}}</p>
        </div>

        <div class="col-md-3">
            {!! Form::label('name', 'Bairro', ['class' => 'required']) !!}
            <p>{{($medico->bairro)}}</p>
        </div>

        <div class="col-md-5">
            {!! Form::label('name', 'Endereço', ['class' => 'required']) !!}
            <p>{{($medico->endereco)}}</p>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            {!! Form::label('name', 'Tipo Sanguíneo', ['class' => 'required']) !!}
            <p>{{$medico->tipo_sanguineo}}</p>
        </div>

        <div class="col-md-4">
            {!! Form::label('name', 'Estado', ['class' => 'required']) !!}
            <p>{{($medico->estado)}}</p>
        </div>
        <div class="col-md-4">
            {!! Form::label('name', 'Sexo', ['class' => 'required']) !!}
            <p>{{($medico->sexo)}}</p>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            {!! Form::label('name', 'Número', ['class' => 'required']) !!}
            <p>{{($medico->numero)}}</p>
        </div>

        <div class="col-md-4">
            {!! Form::label('name', 'Referência', ['class' => 'required']) !!}
            <p>{{($medico->referencia)}}</p>
        </div>
        <div class="col-md-4">
            {!! Form::label('name', 'Observação', ['class' => 'required']) !!}
            <p>{{($medico->observacao)}}</p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left btn-flat" id="fechar"><i class="fa fa-close"></i> Voltar </button>
</div>
{!! Form::close() !!}

