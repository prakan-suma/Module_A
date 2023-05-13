@extends('main')
{{-- This content --}}
@section('content')
    <form id="signup-form" method="POST">
        @csrf

        {{-- Error box  --}}
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <h1>New Account</h1>
        <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <input class="form-control" type="text" name="username">
        </div>

        <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input class="form-control" type="text" name="password">
        </div>

        <button type="submit" class="btn col-3 btn-primary">Register</button>
    </form>

    <script>
        $(function() {
            $('#signup-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '/api/v1/user/signup',
                    method: 'POST',
                    data: formData,
                    success: function(re) {
                        setItem(re.user, re.token)
                        getItem()
                        window.location.href = '/';
                    },
                    error: function(errors) {
                        console.log(errors);
                    }
                });
            });
        });
    </script>
@endsection
