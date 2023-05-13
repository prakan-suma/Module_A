@extends('main')
{{-- This content --}}
@section('content')
    <form id="signin-form" method="post">
        @csrf

        {{-- Errors box  --}}
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <h1>User Signin</h1>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input class="form-control" type="text" name="username" id="">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="text" name="password" id="">
        </div>

        <button type="submit" class="btn col-3 btn-primary">Login</button>
    </form>

    <script>
        $('#signin-form').on('submit', function(e) {
            e.preventDefault()
            const data = $(this).serialize()

            $.ajax({
                url: '/api/v1/user/signin',
                 type: 'POST',
headers: {
                    'Content-Type': 'application/json'
                },
                data: data,
                success: function(re) {
                    setItem(re.user, re.token)
                    window.location.href = '/'
                },
                error: function(error) {
                    console.log(error)
                }
            })
        })
    </script>
@endsection
