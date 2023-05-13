@extends('main')

@section('content')
    <h4>Admin log</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-secondary">
            <th>Username</th>
            <th>Created Timestamp</th>
            <th>Last login</th>
        </thead>

        <tbody>
        @foreach($admins as $admin)
            <tr>
                <td>{{$admin->username}}</td>
                <td>{{$admin->created_at}}</td>
                <td>{{$admin->logined_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
