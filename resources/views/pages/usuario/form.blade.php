<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($usuario)) ? 'Editar' : 'Adicionar' }} Usuário</h4>
</div>
@if(isset($usuario))
    {!! Form::model($usuario, ['action' => ('UsuarioController@store'), 'id' => 'form-usuario']) !!}
@else
    {!! Form::open(['action' => ('UsuarioController@store'), 'id' => 'form-usuario']) !!}
@endif
<div class="modal-body">
    <div class="row">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        <div class="col-md-12">
            {!! Form::hidden('id', null, ['id' => 'id-user']) !!}
            {!! Form::hidden('funcoes', null, ['id' => 'funcoes-values']) !!}
            {!! Form::label('name', 'Nome:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div style="clear: both;"></div>
        <br />
        <div class="col-md-12">
            {!! Form::label('email', 'E-mail:') !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
        <div style="clear: both;"></div>
        <br />
        <div class="col-md-6">
            {!! Form::label('password', 'Senha:') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('repeat-password', 'Confirmar Senha:') !!}
            {!! Form::password('repeat-password', ['class' => 'form-control']) !!}
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('', 'Funções:') !!}
            <div class="input-group input-group">
                {!! Form::select('', $funcoes, null, ['class' => 'form-control', 'id' => 'funcao-option']) !!}
                <span class="input-group-btn">
                        {!! Form::button('Incluir', ['class' => 'btn btn-primary', 'id' => 'add-funcao']) !!}
                    </span>
            </div>
        </div>
        <div class="col-md-12 table-max-height">
            <br />
            <table class="table table-hover">
                <thead>
                <th>Função</th>
                <th>Ações</th>
                </thead>
                <tbody id="table-body-funcoes"></tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer border">
    <button style="margin-right: 68%;" class="btn btn-default pull-left btn-flat" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> Cancelar </button>
    <button type="submit" class="btn btn-success btn-flat" id="salvar-usuario"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Salvar</button>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    loadFuncoes();
</script>