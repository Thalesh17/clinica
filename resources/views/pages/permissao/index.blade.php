@extends('layouts.default')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header page-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="box-title"> <i class="fa fa-sort-amount-asc" aria-hidden="true"></i> Permissões</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row mobile">
                        <div class="col-md-2"></div>
                        {!! Form::open(['action' => ('PermissaoController@index'), 'id' => 'form', 'method' => 'GET']) !!}
                        <div class="col-md-4 col-md-offset-6">
                            <div class="input-group">
                                {!! Form::text('filter', null, ['class' => 'form-control form-control-custom', 'placeholder' => 'Filtrar...']) !!}
                                <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary btn-flat btn_icon_filter btn-block btn-primary-custom"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                        </span>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
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
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissoes as $row)
                                            <tr>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->description }}</td>
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
                                {!! $permissoes->render(); !!}
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <br/>
                                Mostrando {!! $permissoes->firstItem() !!} a {!! $permissoes->lastItem() !!}
                                de {!! $permissoes->total() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts-footer')

@stop