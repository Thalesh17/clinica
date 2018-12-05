@extends('layouts.default')

@section('content')
    <div>
        <div class="column is-8 is-offset-2">
            <div class="panel">
                <div class="panel-heading">
                    {{$friend->name}}
                    <div class="container is-pulled-left">
                        <a href="{{url('chat')}}" class="is-link"><i class="fa fa-arrow-left"></i> Voltar</a>
                    </div>
                    <chat></chat>
                </div>
            </div>
        </div>
    </div>

@stop