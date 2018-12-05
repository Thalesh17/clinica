<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($sistema)) ? 'Editar' : 'Cadastrar' }} Sistema</h4>
</div>
@if(isset($sistema))
    {!! Form::model($sistema, ['action' => ('SistemaController@store'), 'id' => 'tabelas-sistema']) !!}
@else
    {!! Form::open(['action' => ('SistemaController@store'), 'id' => 'tabelas-sistema']) !!}
@endif
<div class="modal-body">
    <div id='alert-modal' class="alert" style="display: none;"></div>
    <div class="row">
        {!! Form::hidden('uuid', null) !!}
        {!! Form::hidden('escopo_uuid', (isset($escopo)) ? $escopo : null) !!}
        <div class="col-md-12">
            {!! Form::label('nome', 'Nome:') !!}
            {!! Form::text('nome', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer border">
    <button type="button" class="btn btn-default pull-left btn-flat" id="fechar" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> Cancelar </button>
    <button type="submit" class="btn btn-success btn-flat" id="salvar-sistema"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Salvar</button>
</div>
{!! Form::close() !!}
