@extends('main')
{{--This content --}}
@section('content')

    <form action="/admin/signin" method="post">
        @csrf
        @if($errors->any())
            <div class="alert alert-danger">{{$errors->first()}}</div>
        @endif
        <h1>Admin Login</h1>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input class="form-control" type="text" name="username" id="">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control"  type="text" name="password" id="">
        </div>

        <button type="submit" class="btn col-3 btn-primary">Login</button>
    </form>
@endsection
