@extends('main')

@section('content')
    <div class="d-flex justify-content-between">
        <h4 class="">Games</h4>
        <div>
            <form action="/game/search" method="post" class="input-group">
                @csrf
                <div class="form-outline">
                    <input type="search" name="keyword" class="form-control">
                </div>
                <button type="submit" class="btn-sm btn-dark">Search</button>
            </form>
        </div>
    </div>

    <div class="row my-5">
        @foreach ($games as $game)
            <div class="card col m-2">
                <img class="card-img-top" src="{{ asset('images/thumbnails/' . $game->thumbnail) }}" alt="Thumnail"
                    height="150">
                <div class="card-body">
                    <h5 class="card-title">{{ $game->title }}</h5>
                    <p class="card-text">{{ $game->description }}</p>
                    <p class="card-text">{{ $game->user->username }}</p>
                    <p class="card-text">{{ $game->currentVersion->created_at }}</p>
                </div>
                <div class="card-body">
                    <a href="/game/{{ $game->slug }}" class="btn-sm btn-dark mx-0">Play</a>
                    <a href="/admin/delete/{{ $game->id }}" class="btn-sm btn-primary">Delete</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
