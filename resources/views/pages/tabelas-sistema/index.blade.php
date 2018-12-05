@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <h2><i class="fa fa-table"></i> Tabelas do Sistema</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <a href="{{ url('funcao') }}" class="table-list">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-folder-open"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Funções</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ url('permissao') }}" class="table-list">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-sort-amount-asc"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Permissões</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ url('especialidade') }}" class="table-list">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-file-medical"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Especialidade</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ url('sexo') }}" class="table-list">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-venus-mars"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Sexo</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ url('tipo-sanguineo') }}" class="table-list">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-dna"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Tipo Sanguíneo</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ url('paciente/') }}" class="table-list">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pacientes</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ url('medico') }}" class="table-list">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-user-md"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Médicos</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ url('consulta') }}" class="table-list">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fas fa-hospital"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Consultas</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>

    </div>

@endsection