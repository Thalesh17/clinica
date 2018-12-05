<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Optional theme -->
{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">--}}
<!-- Latest compiled and minified JavaScript -->
    <link rel="stylesheet" type="text/css" href="{{asset('AdminLTE/plugins/datatables/jquery.dataTables.min.css/')}}">

    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/iCheck/flat/blue.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/morris/morris.css')}}">
    <!-- jvectormap -->
{{--    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">--}}
<!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datepicker/datepicker3.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker-bs3.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">


    <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/c3/c3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('AdminLTE/plugins/iCheck/minimal/blue.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('AdminLTE/plugins/iCheck/flat/red.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('AdminLTE/plugins/iCheck/flat/blue.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('AdminLTE/plugins/iCheck/square/blue.css') }}"/>
    {{--//FULLCALENDAR--}}

    <link rel="stylesheet" type="text/css" href="{{ asset('AdminLTE/plugins/bootstrap-slider/slider.css') }}"/>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Font Awesome -->
{{--    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">--}}
<!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/skins/_all-skins.min.css') }}">
    <!-- Alert dialogs -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/sweetalert/sweetalert2.min.css') }}">
    <!-- Styles Css -->
    <!-- jQuery Confirm Style-->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/jQueryConfirm/jquery-confirm.min.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Select Two -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/select2/dist/css/select2.css') }}">
    <!-- ColorPicker Bootstrap -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <!-- ColorPicker Bootstrap -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/nestable/nestable.css') }}">
    <!-- ColorPicker Bootstrap -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/pace/pace.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/datetimepicker/jquery.datetimepicker.css')}}">


    <!-- Script html header -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/preload-custom/preload-custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}"/>
    <script src="{{ asset('/AdminLTE/plugins/preload-custom/preload-custom.js') }}"></script>


    <!-- jQuery 3.2.1 -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>


    <script src="{{asset('AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script src="{{ asset('/plugins/c3/d3.v3.min.js') }}"></script>
    <script src="{{ asset('/plugins/c3/c3.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{asset('AdminLTE/plugins/morris/morris.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('AdminLTE/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
<!-- jvectormap -->
    <script src="{{asset('AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('AdminLTE/plugins/knob/jquery.knob.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('AdminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <!-- datepicker -->
    <script src="{{asset('AdminLTE/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{asset('AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{asset('AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{{ asset('/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('/plugins/fullcalendar/locale/pt-br.js') }}"></script>
    <script src="{{asset('AdminLTE/plugins/fastclick/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('AdminLTE/dist/js/adminlte.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('AdminLTE/dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('AdminLTE/dist/js/demo.zjs')}}"></script>


    <!-- SlimScroll -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Funções JavaScripts -->
    <script type="text/javascript" src="{{ asset('/js/funcoesJavaScript.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/form-error-message.js') }}"></script>

    <!-- Select Two -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/select2/dist/js/i18n/pt-br.js') }}"></script>
    <!-- SweetAlert Plugin Js -->
    <script type="text/javascript" src="{{ asset('AdminLTE/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <!-- jQuery Confirm -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/jQueryConfirm/jquery-confirm.min.js') }}"></script>
    <!-- ColorPicker Bootstrap -->
    <script type="text/javascript" src="{{ asset('AdminLTE/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- AdminLTE App -->
    <!-- InputMask -->
    <script src="{{ asset('AdminLTE/plugins/input-mask/inputmask.dependencyLib.jquery.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/input-mask/jquery.inputmask.numeric.extensions.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <!-- TodoList -->
    <script src="{{ asset('AdminLTE/plugins/todo-list/todo-list.js') }}"></script>
    <!-- Pace -->
    <script src="{{ asset('AdminLTE/bower_components/PACE/pace.min.js') }}"></script>
    <!-- Form Error message  -->
    <script src="{{asset('plugins/datetimepicker/build/jquery.datetimepicker.full.min.js')}}"></script>

</head>