@extends('main')

@section('content')
    @if ($errors->any())
        <div class="alert alert-sm alert-secondary">{{ $errors->first() }}</div>
    @endif
    <h4>User log</h4>
    <table class="table table-bordered table-hover table-striped">
        <thead class="table-secondary">
            <th>Username</th>
            <th>Registraion timestamp</th>
            <th>Last login timestamp</th>
            <th>Profile</th>
            <th>Block User</th>
            <th>Unblocked</th>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->logined_at }}</td>
                    <td>
                        <a class="btn btn-sm btn-warning m-0 col" href="/user/{{ $user->username }}">Profile ></a>
                    </td>
                    <td>
                        <form action="/admin/block" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <select class="form-control" name="block">
                                        <option value="">Select one comment</option>
                                        <option value="You have been blocked by an administrator.">You have been blocked by an administrator.</option>
                                        <option value="You have been blocked for spamming.">You have been blocked for spamming.</option>
                                        <option value="You have been blocked for cheating.">You have been blocked for cheating.</option>
                                    </select>
                                    </datalist>
                                </div>

                                <div class="col">
                                    <button class="btn btn-sm btn-danger m-0 " type="submit">Block</button>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-dark m-0 col" href="/admin/unblock/{{ $user->id }}">Unblock</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
