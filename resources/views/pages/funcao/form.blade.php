<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($funcao)) ? 'Editar' : 'Cadastrar' }} Função</h4>
</div>
@if(isset($funcao))
    {!! Form::model($funcao, ['action' => ('FuncaoController@store'), 'id' => 'form-funcao']) !!}
@else
    {!! Form::open(['action' => ('FuncaoController@store'), 'id' => 'form-funcao']) !!}
@endif
<div class="modal-body">
    <div id='alert-modal' class="alert" style="display: none;"></div>
    <div class="row">
        {!! Form::hidden('id', null, ['id' => 'id-role' ]) !!}
        {!! Form::hidden('permissoes', null, ['id' => 'permissoes-values']) !!}
        <div class="col-md-4">
            {!! Form::label('name', 'Nome', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-8">
            {!! Form::label('description', 'Descrição', ['class' => 'required']) !!}
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('pemissao', 'Permissões', ['class' => 'required']) !!}
            <div class="input-group input-group">
                {!! Form::select('pemissao', $permissoes, null, ['class' => 'form-control select2', 'id' => 'permissao-option']) !!}
                <span class="input-group-btn">
                        {!! Form::button('Incluir', ['class' => 'btn btn-primary btn-flat', 'id' => 'add-permissao']) !!}
                    </span>
            </div>
        </div>
        <div class="col-md-12 table-max-height">
            <br />
            <table class="table table-hover">
                <thead>
                <th>Permissão</th>
                <th>Ações</th>
                </thead>
                <tbody id="table-body-permissoes"></tbody>
            </table>
        </div>

    </div>
</div>
<div class="modal-footer border">
    <button type="button" class="btn btn-default pull-left btn-flat" id="fechar" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> Cancelar </button>
    <button type="submit" class="btn btn-success btn-flat" id="salvar-funcao"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Salvar</button>
</div>
{!! Form::close() !!}

<script type="text/javascript">
    loadPermissoes();
</script>
