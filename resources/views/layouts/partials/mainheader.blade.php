<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        @if(validateMasterAccess())
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('usuario/profile')}}" class="nav-link">Perfil</a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('consulta')}}" class="nav-link">Consultas</a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('paciente')}}" class="nav-link">Pacientes</a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('medico')}}" class="nav-link">Médicos</a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('paciente/create')}}" class="nav-link">Cadastrar Paciente</a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('medico/create')}}" class="nav-link">Cadastrar Médico</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('usuario/profile')}}" class="nav-link">Perfil</a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('consulta/informativo')}}" class="nav-link">Informativos</a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('consulta/usuario')}}" class="nav-link">Suas Consultas</a>
            </li>
        @endif
    </ul>

<!-- Right navbar links -->
    {{--<ul class="navbar-nav ml-auto">--}}
        {{--<!-- Messages Dropdown Menu -->--}}
        {{--<li class="nav-item dropdown">--}}
            {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
                {{--<i class="fa fa-comments-o"></i>--}}
                {{--<span class="badge badge-danger navbar-badge">3</span>--}}
            {{--</a>--}}
            {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<!-- Message Start -->--}}
                    {{--<div class="media">--}}
                        {{--<img src="{{asset('AdminLTE/dist/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">--}}
                        {{--<div class="media-body">--}}
                            {{--<h3 class="dropdown-item-title">--}}
                                {{--Brad Diesel--}}
                                {{--<span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>--}}
                            {{--</h3>--}}
                            {{--<p class="text-sm">Call me whenever you can...</p>--}}
                            {{--<p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- Message End -->--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<!-- Message Start -->--}}
                    {{--<div class="media">--}}
                        {{--<img src="{{asset('AdminLTE/dist/img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
                        {{--<div class="media-body">--}}
                            {{--<h3 class="dropdown-item-title">--}}
                                {{--John Pierce--}}
                                {{--<span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>--}}
                            {{--</h3>--}}
                            {{--<p class="text-sm">I got your message bro</p>--}}
                            {{--<p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- Message End -->--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<!-- Message Start -->--}}
                    {{--<div class="media">--}}
                        {{--<img src="{{asset('AdminLTE/dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
                        {{--<div class="media-body">--}}
                            {{--<h3 class="dropdown-item-title">--}}
                                {{--Nora Silvester--}}
                                {{--<span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>--}}
                            {{--</h3>--}}
                            {{--<p class="text-sm">The subject goes here</p>--}}
                            {{--<p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- Message End -->--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>--}}
            {{--</div>--}}
        {{--</li>--}}
        {{--<!-- Notifications Dropdown Menu -->--}}
        {{--<li class="nav-item dropdown">--}}
            {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
                {{--<i class="fa fa-bell-o"></i>--}}
                {{--<span class="badge badge-warning navbar-badge">15</span>--}}
            {{--</a>--}}
            {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
                {{--<span class="dropdown-item dropdown-header">15 Notifications</span>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<i class="fa fa-envelope mr-2"></i> 4 new messages--}}
                    {{--<span class="float-right text-muted text-sm">3 mins</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<i class="fa fa-users mr-2"></i> 8 friend requests--}}
                    {{--<span class="float-right text-muted text-sm">12 hours</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<i class="fa fa-file mr-2"></i> 3 new reports--}}
                    {{--<span class="float-right text-muted text-sm">2 days</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
            {{--</div>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
            {{--<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fa fa-th-large"></i></a>--}}
        {{--</li>--}}
    {{--</ul>--}}
</nav>

<!-- /.navbar -->

{{--<header class="main-header">--}}

    {{--<!-- Header Navbar: style can be found in header.less -->--}}
    {{--<nav class="navbar navbar-static-top">--}}
        {{--<!-- Sidebar toggle button-->--}}
        {{--<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">--}}
            {{--<span class="sr-only">Toggle navigation</span>--}}
            {{--<span class="icon-bar"></span>--}}
            {{--<span class="icon-bar"></span>--}}
            {{--<span class="icon-bar"></span>--}}
        {{--</a>--}}

        {{--<div class="navbar-custom-menu">--}}
            {{--<ul class="nav navbar-nav">--}}
                {{--<!-- User Account: style can be found in dropdown.less -->--}}
                {{--<li class="dropdown user user-menu">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                        {{--<i class="glyphicon glyphicon-user"></i>--}}
                        {{--<span class="hidden-xs">{{ \Auth::user()->name }}</span>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<!-- User image -->--}}
                        {{--<li class="user-header">--}}
                            {{--<h1 style="color: #FFF"><i class="fa fa-user"></i></h1>--}}
                            {{--<p>--}}
                                {{--{{ \Auth::user()->name }}--}}
                                {{--<small>{{ \Auth::user()->email }}</small>--}}
                            {{--</p>--}}
                        {{--</li>--}}

                        {{--<!-- Menu Footer-->--}}
                        {{--<li class="user-footer">--}}
                            {{--<div class="pull-left">--}}
                                {{--<a  href="{{url('/usuario/profile')}}" class="btn btn-default btn-flat">--}}
                                    {{--<i class="glyphicon glyphicon-user"></i> Perfil--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            {{--<div class="pull-right">--}}
                                {{--@if(\Auth::check())--}}
                                    {{--<a href="{{ route('logout') }}"--}}
                                       {{--onclick="event.preventDefault();--}}
                                                     {{--document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">--}}
                                        {{--<i class="glyphicon glyphicon-log-out"></i> Sair--}}
                                    {{--</a>--}}

                                    {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                                        {{--{{ csrf_field() }}--}}
                                    {{--</form>--}}
                                {{--@else--}}
                                    {{--<a href="{{ url('/login') }}" class="btn btn-default btn-flat">Entrar <i class="glyphicon glyphicon-log-in"></i></a>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</nav>--}}
{{--</header>--}}