@section('styles-header')
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/sweetalert/sweetalert2.min.css') }}">
@stop
@php
    $permissions = getPermissionsPage();
@endphp


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('AdminLTE/dist/img/AdminLTELogo.png')}}" alt="Clinica Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Clinica JP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{isset(Auth::user()->image) ? asset(asset('storage/users/'.Auth::user()->image)) : asset('AdminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{\Auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                    {{--<a href="#" class="nav-link">--}}
                        {{--<i class="fab fa-dashcube"></i>--}}
                        {{--<p>--}}
                            {{--Clinica - JP--}}
                            {{--<i class="right fa fa-angle-left"></i>--}}
                        {{--</p>--}}
                    {{--</a>--}}
{{--                @if(validatePermission($permissions, ['HISTORICO_CONSULTAS_PACIENTE_LOGADO']))--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="{{url('consulta/historico')}}" class="nav-link">--}}
                        {{--<i class="nav-icon fa fa-book"> </i>--}}
                        {{--<p>--}}
                            {{--Consulta Médico--}}
                        {{--</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--@endif--}}
{{--                @if(validatePermission($permissions, ['HISTORICO_CONSULTAS_PACIENTE_LOGADO']))--}}
                {{--<li class="nav-item has-treeview">--}}
                    {{--<a onclick="agendar()" class="nav-link">--}}
                        {{--<i class="nav-icon fa fa-id-card-alt"></i>--}}
                        {{--<p>--}}
                            {{--Agendar Consulta--}}
                        {{--</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--@endif--}}
{{--                @if(validatePermission($permissions, ['HISTORICO_CONSULTAS_PACIENTE_LOGADO']))--}}
                {{--@if(validatePermission($permissions, ['INFORMATIVO_MEDICO', 'INFORMATIVO_PACIENTE']))--}}
                @if(validateLogin(['PACIENTE', 'MEDICO']))
                    <li class="nav-item has-treeview">
                        <a href="{{url('usuario/profile')}}" class="nav-link">
                            <i class="nav-icon fa fa-address-book"></i>
                            <p>
                                Profile
                            </p>
                        </a>
                    </li>
                @endif
                @if(validatePermission($permissions, ['CALENDARIO_MEDICO', 'CONSULTAS_MEDICO']))
                    <li class="nav-item has-treeview">
                        <a href="{{url('medico/calendario')}}" class="nav-link">
                            <i class="nav-icon fa fa-calendar"></i>
                            <p>
                                Calendário
                            </p>
                        </a>
                    </li>
                @endif
                @if(validateMasterAccess())
                    <li class="nav-item has-treeview">
                        <a href="{{url('consulta/atendimento')}}" class="nav-link">
                            <i class="nav-icon fa fa-notes-medical"></i>
                            <p>
                                Atendimento
                            </p>
                        </a>
                    </li>
                @endif
                @if(validatePermission($permissions, ['INFORMATIVO_MEDICO', 'INFORMATIVO_PACIENTE']))

                    <li class="nav-item has-treeview">
                        <a href="{{url('consulta/informativo')}}" class="nav-link">
                            <i class="nav-icon fa fa-chart-pie"></i>
                            <p>
                                Informativos
                            </p>
                        </a>
                    </li>
                @endif
                {{--@endif--}}
                @if(validatePermission($permissions, ['CONSULTAS_PACIENTE', 'CONSULTAS_MEDICO']))
                <li class="nav-item">
                    <a href="{{url('consulta/usuario')}}" class="nav-link">
                        <i class="nav-icon fa fa-book"> </i>
                        <p>
                            Suas Consultas
                        </p>
                    </a>
                </li>
                @endif
                    @if(validateMasterAccess())
                    <li class="nav-item">
                        <a href="{{url('consulta')}}" class="nav-link">
                            <i class="nav-icon fa fa-book"> </i>
                            <p>
                                Consultas
                            </p>
                        </a>
                    </li>
                    @endif
                {{--<li class="nav-item has-treeview">--}}
                    {{--<a href="#" class="nav-link">--}}
                        {{--<i class="nav-icon fa fa-pie-chart"></i>--}}
                        {{--<p>--}}
                            {{--Painel do Médico--}}
                            {{--<i class="right fa fa-angle-left"></i>--}}
                        {{--</p>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-treeview">--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="pages/charts/chartjs.html" class="nav-link">--}}
                                {{--<i class="fa fa-circle-o nav-icon"></i>--}}
                                {{--<p>Seus pacientes</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="pages/charts/flot.html" class="nav-link">--}}
                                {{--<i class="fa fa-circle-o nav-icon"></i>--}}
                                {{--<p>Atendimentos</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="pages/charts/inline.html" class="nav-link">--}}
                                {{--<i class="fa fa-circle-o nav-icon"></i>--}}
                                {{--<p>Consultas</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                @if(validateRoles(['ADMINISTRADOR']))
                    <li class="nav-item has-treeview">
                        <a href="{{url('paciente')}}" class="nav-link">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                Pacientes
                            </p>
                        </a>
                    </li>
                @endif
                @if(validateRoles(['ADMINISTRADOR']))
                    <li class="nav-item has-treeview">
                        <a href="{{url('medico')}}" class="nav-link">
                            <i class="nav-icon fa fa-user-md"></i>
                            <p>
                                Medicos
                            </p>
                        </a>
                    </li>
                @endif
                @if(validateRoles(['ADMINISTRADOR']))
                <li class="nav-item has-treeview">
                    <a href="{{url('paciente/create')}}" class="nav-link">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            Cadastrar Paciente
                        </p>
                    </a>
                </li>
                @endif
                @if(validateRoles(['ADMINISTRADOR']))
                <li class="nav-item has-treeview">
                    <a href="{{url('medico/create')}}" class="nav-link">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            Cadastrar Médico
                        </p>
                    </a>
                </li>
                @endif
                {{--<li class="nav-item has-treeview">--}}
                    {{--<a href="{{url('medico/')}}" class="nav-link">--}}
                        {{--<i class="nav-icon fa fa-user-md"></i>--}}
                        {{--<p>--}}
                            {{--Médicos--}}
                        {{--</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item has-treeview">--}}
                    {{--<a href="{{url('paciente/')}}" class="nav-link">--}}
                        {{--<i class="nav-icon fa fa-user-edit"></i>--}}
                        {{--<p>--}}
                            {{--Pacientes--}}
                        {{--</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item has-treeview">--}}
                    {{--<a href="#" class="nav-link">--}}
                        {{--<i class="nav-icon fa fa-edit"></i>--}}
                        {{--<p>--}}
                            {{--Historico--}}
                        {{--</p>--}}
                    {{--</a>--}}
            {{--</li>--}}
                @if(validateMasterAccess())

                    <li class="nav-header">Configuração</li>
                <li class="nav-item has-treeview">
                    <<a href="#" class="nav-link">
                        <i class="nav-icon fa fa-pie-chart"></i>
                        <p>
                            Configuração
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" id="configuracoes">
                        <li class="nav-item">
                            <a href="{{url('/usuario')}}" class="nav-link">
                                <i class="fa fa-users"></i>
                                <p>  Usuários</p></a>
                        </li>
                        <li class="nav-item">
                            <li>
                                <a href="{{url('tabelas-sistema')}}" class="nav-link">
                                    <i class="fa fa-table"></i>
                                    <p> Tabelas do Sistema</p>
                                </a>
                            </li>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/configuracao')}}" class="nav-link">
                                <i class="fa fa-cogs"></i>
                                <p> Configuração</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="nav-header">LABELS</li>
                <li class="nav-item">
                    @if(\Auth::check())
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();" class="a-custom-d">
                            <i class="glyphicon glyphicon-off"> Sair</i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="btn btn-default btn-flat"> Entrar <i class="glyphicon glyphicon-log-in"></i></a>
                    @endif
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
{{--<aside class="main-sidebar">--}}
    {{--<!-- sidebar: style can be found in sidebar.less -->--}}
    {{--<section class="sidebar">--}}
        {{--<!-- Sidebar user panel -->--}}
        {{--<div class="user-panel">--}}
            {{--<div class="pull-left image">--}}
                {{--<img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}
            {{--</div>--}}
            {{--<div class="pull-left info">--}}
                {{--<p>{{ \Auth::user()->name }}</p>--}}
                {{--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<!-- sidebar menu: : style can be found in sidebar.less -->--}}
        {{--<ul class="sidebar-menu" data-widget="tree">--}}
            {{--<li class="header">MENU</li>--}}
            {{--<!-- Optionally, you can add icons to the links -->--}}
            {{--<li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i> <span >Home</span></a></li>--}}
            {{--<li><a href="{{ url('/parque-turbina') }}"><i class="fa fa-modx"></i> <span >Parques & Turbinas</span></a></li>--}}
            {{--<li><a href="{{ url('/escopo') }}"><i class="fa  fa-object-group"></i> <span >Escopo</span></a></li>--}}
            {{--<li><a href="{{ url('/inspecao') }}"><i class="fa  fa-clipboard"></i> <span >Inspeção</span></a></li>--}}
            {{--<li class="treeview" id="configuracoes">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-cogs"></i> <span>Configurações</span>--}}
                    {{--<span class="pull-right-container">--}}
                        {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}

                    {{--<li><a href="{{url('/usuario')}}"><i class="fa fa-users"></i> Usuários</a></li>--}}

                    {{--<li><a href="{{url('tabelas-sistema')}}"><i class="fa fa-table"></i> <span> Tabelas do Sistema</span></a></li>--}}

                    {{--<li><a href="{{url('/configuracao')}}"><i class="glyphicon glyphicon-cog"></i> <span> Configuração</span></a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</section>--}}
    {{--<!-- /.sidebar -->--}}
{{--</aside>--}}
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-consulta', 'idContent' => 'content-modal-consulta'])

{{--@section('scripts')--}}
    <script type="text/javascript" src="{{ asset('AdminLTE/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    {{--<script>--}}
        {{--var urlBase = '{{ url('') }}/';--}}
        {{--function agendar() {--}}
                {{--$.get(urlBase + "consulta/create/", function(resposta){--}}
                    {{--$("#content-modal-consulta").html(resposta);--}}
                    {{--$('#modal-form-consulta').modal('show');--}}
                {{--}).fail(function(resposta) {--}}

                {{--});--}}
        {{--}--}}
    {{--</script>--}}
    {{--<script type="text/javascript" src="{{ asset('js/app/consulta.js') }}"></script>--}}
{{--@stop--}}
