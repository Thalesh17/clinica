@extends('layouts.default')

@section('content')

    <div class="main-header-custom">
        <div class="row" style="">
            <div class="row row-title">
                <div class="col-md-12">
                    <h2 class="box-title" style="color: #777777e3;"><i class="fa fa-user-md"></i><b>  Calendário de consultas</b></h2>
                </div>
            </div>
        </div>
        <div class="box-body box-pad">
            <div id='alert' class="alert " style="display: none;"></div>
            <div class="row mobile">

            </div>
        </div>
    </div>

    <div>
        <div id="calendario"></div>
    </div>


@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/app/calendario.js') }}"></script>
@stop
