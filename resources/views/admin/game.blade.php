@extends('main')

@section('content')
    <div class="d-flex justify-content-between">
        <h4 class="">Games</h4>
        <div>
            <form action="/admin/search" method="post" class="input-group">
                @csrf
                <div class="form-outline">
                    <input type="text" name="keyword" class="form-control">
                </div>
                <button type="submit" class="btn-sm btn-dark">Search</button>
            </form>
        </div>
    </div>

    <div class="row my-5">
        @foreach ($games as $game)
            <div class="card col m-2  @if ($game->delete_status) alert-danger @endif">
                @if ($game->delete_status)
                    <h3>Deleted</h3>
                @endif
                <img class="card-img-top" src="{{ asset('images/thumbnails/' . $game->thumbnail) }}" alt="Thumnail"
                    height="150">
                <div class="card-body">
                    <h5 class="card-title">{{ $game->title }}</h5>
                    <p class="card-text">{{ $game->description }}</p>
                    <p class="card-text">{{ $game->user->username }}</p>
                    <p class="card-text">{{ $game->currentVersion->created_at }}</p>
                </div>

                @if ($game->delete_status)
                    <a href="/admin/score/{{ $game->id }}" class="btn-sm btn-dark col-3">See score</a>
                @else
                    <div class="card-body">
                        <a href="/admin/score/{{ $game->id }}" class="btn-sm btn-dark col-3">See score</a>
                        <a href="/admin/delete/{{ $game->id }}" class="btn-sm btn-primary">Delete</a>
                    </div>
                @endIf
            </div>
        @endforeach
    </div>
@endsection
