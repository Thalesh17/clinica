<!DOCTYPE html>
<html lang="pt-br">
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
    <style>
        /*Skin Azul */
       .skin-blue-pattern, .skin-blue-light-pattern{
            background: linear-gradient(141deg, #085B8C 0%, #1E77AB 51%,  #3C8CBC 75%);
       }

        /*Skin Verde */
       .skin-green-pattern, .skin-green-light-pattern{
            background: linear-gradient(141deg, #008448 0%, #00a65a 51%,  #23B372 75%);
       }

        .skin-green-pattern .btn-success, .skin-green-light-pattern .btn-success{
            border-color: #fff;
        }

        /*Skin Red */
       .skin-red-pattern, .skin-red-light-pattern{
            background: linear-gradient(141deg, #BB2D1A 0%, #dd4b39 51%,  #F57160 75%);
       }

        /*Skin Purple */
       .skin-purple-pattern, .skin-purple-light-pattern{
            background: linear-gradient(141deg, #433E8F 0%, #605ca8 51%,  #8985C5 75%);
       }

        /*Skin Yellow */
       .skin-yellow-pattern, .skin-yellow-light-pattern{
            background: linear-gradient(141deg, #FCB544 0%, #f39c12 51%,  #C07704 75%);
       }

        /*Skin Black */
       .skin-back-pattern, .skin-black-light-pattern{
            background: linear-gradient(141deg, #fff 0%, #eae7e7 51%,  #d6d6d6 75%);
       }

        .skin-back-pattern .btn-link-person , .skin-black-light-pattern .btn-link-person{
          color : #4a4a4a;
        }

        .skin-back-pattern .btn-link-person:hover , .skin-black-light-pattern .btn-link-person:hover{
          color : #000;
        }

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

        .header{
            background-image: url('/img/fundo.jpg');
            background-size: cover;
            background-blend-mode: color-burn;
            background-color: #dcecdc;
        }

    </style>
    <!-- jQuery 3.2.1 -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</head>
<body class="{{ getSkinPattern() }} header">
    @yield('content')
</body>
</html>