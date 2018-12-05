@extends('layouts.default')

@section('content')
    <div class="main-header-custom">
        <div class="row" style="">
            <div class="row row-title">
                <div class="col-md-12">
                    <h2 class="box-title" style="color: #777777e3;"><i class="fas fa-folder-open"></i><b>  Funções</b></h2>
                </div>
            </div>
        </div>
        <div class="box-body box-pad">
            <div id='alert' class="alert " style="display: none;"></div>
            <div class="row mobile">
                <div class="col-md-6">
                    {!! Form::open(['action' => ('FuncaoController@index'), 'id' => 'form', 'method' => 'GET']) !!}
                    <div class="col-md-8 padding-none">
                        <div class="input-group">
                            {!! Form::text('filter', null, ['class' => 'form-control form-control-custom', 'placeholder' => 'Filtrar...']) !!}
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat btn_icon_filter btn-block btn-primary-custom"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-4 col-filter">
                    <button class="col-md-4 btn btn-primary btn-flat btn-block  btn-primary-custom" onclick="inserirFuncao();"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Descrição</th>
                                            <th style="width: 10%; text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($funcoes as $row)
                                            <tr>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->description }}</td>
                                                <td style="text-align: center;">
                                                    <button type="button" class="btn btn-cust-primary btn-xs btn-flat" data-toggle="tooltip" title="Editar" onclick="editarFuncao('{{$row->id}}')">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-cust-danger btn-xs btn-flat" data-toggle="tooltip" title="Deletar" onclick="deletarFuncao('{{ $row->id }}', '{{$row->description}}')">
                                                        <i class="glyphicon glyphicon-trash"></i>&nbsp;
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-9 skin-pattern">
                                {!! $funcoes->render(); !!}
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <br/>
                                Mostrando {!! $funcoes->firstItem() !!} a {!! $funcoes->lastItem() !!}
                                de {!! $funcoes->total() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-funcao', 'idContent' => 'content-modal-funcao'])
@stop

@section('scripts-footer')
    <script src=" {{ asset('js/app/funcao.js') }} "></script>
@stop