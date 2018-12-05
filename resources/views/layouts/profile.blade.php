<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ config('app.name') }}</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}">
    <!-- Styles Css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Alert dialogs -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/sweetalert/sweetalert2.min.css') }}">
    <style>

        .logo-login{
            padding: 15%;
            text-align: center;
            font-size: 2em;
        }
        .logo-login a{
           color : #000;
        }

        .logo-login a:hover{
           color : #191818;
            text-decoration: none;
        }
        .btn-link-person{
            color: #efefef;
        }

        .btn-link-person:hover{
            color: #ded9d9;
            text-decoration: none;
        }
        label{
            color: black;
        }
        .input-group-addon i{
            color: black;
        }

        .form-group.has-error .form-control, .form-group.has-error .input-group-addon i{
            border-color : #dd4b39 !important;
            color: #dd4b39 !important;
        }

        .form-group.has-error label{
            color : #dd4b39 !important;
        }

        .form-group.has-error .help-block{
            color : #dd4b39 !important;
        }

        .help-block{
            margin-bottom: 0;
        }

    </style>
    <!-- jQuery 3.2.1 -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- SweetAlert Plugin Js -->
    <script type="text/javascript" src="{{ asset('AdminLTE/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/funcoesJavaScript.js') }}"></script>
    <script type="text/javascript">
        var urlBase = '{{ url('') }}/';
    </script>
</head>
<body class="{{ getSkinPattern() }}">
    @yield('content')
</body>
</html>
