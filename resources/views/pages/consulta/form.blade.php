
<div class="modal-header">
    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
        {{--<span aria-hidden="true">×</span></button>--}}
    <h4 class="modal-title"> {{ (isset($consulta)) ? 'Editar' : 'Marcar' }} Consulta</h4>
</div>
@if(isset($consulta))
    {!! Form::model($consulta, ['action' => ('ConsultaController@store'), 'id' => 'form-consulta']) !!}
@else
    {!! Form::open(['action' => ('ConsultaController@store'), 'id' => 'form-consulta']) !!}
@endif
<div class="modal-body">
    <div id='alert-modal' class="alert" style="display: none;"></div>
    {!! Form::hidden('id', null) !!}
    <div class="row">
            <div class="col-md-6">
                {!! Form::label('paciente_id', 'Paciente', ['class' => 'required']) !!}
                {!! Form::select('paciente_id', $paciente, null, ['class' => 'form-control', validateLogin(['PACIENTE']) == true ? 'disabled' : '']) !!}
            </div>
        <div class="col-md-6">
            {!! Form::label('especialidade_id', 'Especialidade', ['class' => 'required']) !!}
            {!! Form::select('especialidade_id', $especialidade, null, ['class' => 'form-control', 'id' => 'especialidade-select', 'onchange' => 'return getMedico(event)']) !!}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            {!! Form::label('medico_id', 'Médico', ['class' => 'required']) !!}
            {!! Form::select('medico_id', isset($medico) ? $medico : ['Selecione'], null, ['class' => 'form-control', 'id' => 'medico-select']) !!}
        </div>
        <div class="col-md-4">
            {!! Form::label('data_consulta', 'Data Consulta', ['class' => 'required']) !!}
            {!! Form::text('data_consulta', isset($consulta) ? $consulta->data_consulta : null, ['class' => 'form-control', 'id' => 'date', 'autocomplete' => 'off']) !!}
        </div>
        <div class="col-md-4">
            {!! Form::label('horario_consulta', 'Horário', ['class' => 'required']) !!}
            {!! Form::select('horario_consulta', [], null, ['class' => 'form-control', 'id' => 'teste']) !!}
        </div>
        {{--<div class="col-md-4">--}}
            {{--{!! Form::label('horario_consulta', 'Horário', ['class' => 'required']) !!}--}}
            {{--{!! Form::text('horario_consulta', null, ['class' => 'form-control', 'id' => 'time', 'autocomplete' => 'off']) !!}--}}
        {{--</div>--}}
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('observacao', 'Observação', ['class' => 'required']) !!}
            {!! Form::textarea('observacao', null, ['class' => 'form-control area']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('sintoma', 'Sintomas', ['class' => 'required']) !!}
            {!! Form::textarea('sintoma', null, ['class' => 'form-control area']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button style="margin-right: 68%;" class="btn btn-default pull-left btn-flat" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> Cancelar </button>

    <button class="btn btn-success btn-flat" id="salvar">&nbsp; Salvar</button>
</div>
{!! Form::close() !!}
<script type="text/javascript" src="{{ asset('js/app/consulta.js') }}"></script>

