<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoSanguineo)) ? 'Editar' : 'Adicionar' }} Tipo Sanguíneo</h4>
</div>
@if(isset($tipoSanguineo))
    {!! Form::model($tipoSanguineo, ['action' => ('TipoSanguineoController@store'), 'id' => 'form-tipo-sanguineo']) !!}
@else
    {!! Form::open(['action' => ('TipoSanguineoController@store'), 'id' => 'form-tipo-sanguineo']) !!}
@endif
<div class="modal-body">
    <div id='alert-modal' class="alert" style="display: none;"></div>
    {!! Form::hidden('id', null) !!}
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('descricao', 'Descrição', ['class' => 'required']) !!}
            {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left btn-flat" id="fechar"><i class="fa fa-close"></i> Cancelar </button>
    <button type="submit" class="btn btn-success btn-flat" id="salvar"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Salvar</button>
</div>
{!! Form::close() !!}
