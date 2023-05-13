@extends('main')

@section('content')
    <div class="row">
        <div class="col">
            <h4>{{ $score->title }}</h4>
            <h6>Version {{ $score->currentVersion->files }}</h6>
        </div>
        <div class="col-3">
            <a class="btn btn-primary " href="/admin/resetscore/{{ $score->id }}">Reset Highscores </a>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-secondary">
            <th>ID</th>
            <th>Username</th>
            <th>Score</th>
            <th>Delete</th>
        </thead>

        <tbody>
            @foreach ($score->currentVersion->scores as $s)
                <tr class="item-center">
                    <td>{{ $s->user_id }}</td>
                    <td>{{ $s->user->username }}</td>
                    <td>{{ $s->score }}</td>
                    <td>
                        <a href="/admin/deletescore/{{ $s->id }}" class="btn btn-secondary">Delete</a>
                        <a href="/admin/deleteall/{{ $s->user_id }}" class="btn btn-secondary">Delete all versions</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
