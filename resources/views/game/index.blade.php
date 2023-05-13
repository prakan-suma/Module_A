@extends('main')

@section('content')
    <div>
        <h4>{{ $game->game->title }}</h4>
        <iframe src="{{ asset("storage/$game->files/index.html") }}" style="height: 550px; width: 100%"></iframe>
        <div class="col">{{$game->game->description}}</div>
    </div>

@endsection
