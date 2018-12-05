@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="columnn is-8 is-offset-2">
            <a class="panel">
                <div class="panel-heading">
                    Lista de Amigos
                </div>
                @forelse($friends as $friend)
                    <a href="{{route('chat.show', $friend->id)}}">
                        {{$friend->name}}
                    </a>
                @empty
                    <div class="panel-block">
                        Você não tem nenhum amigo.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@stop