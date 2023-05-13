<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Games Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        a {
            color: #1a202c;
            margin: 0.5rem;
            text-decoration: none;
        }
    </style>
</head>

<body>
    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>

    {{-- Custom script  --}}
    <script src="{{ asset('js/main.js') }}"></script>

    {{-- Navbar  --}}
    <nav class="navbar  mt-2 mb-5 mx-5">
        <div>
            <a class="navbar-brand text-dark" href="/">Games</a>
        </div>
        <script>
            // Nav bar
            if (localStorage.getItem('user')) {
                var user = localStorage.getItem('user')
                var token = localStorage.getItem('token')
                log(user)
                log(token)
                document.write(`
                <div>
                    <a href="/">Home</a>
                    <a href="/api/v1/user/${user.username}">Profile</a>
                    <a href="/game/create">Upload Game</a>
                    <a href="/game/control">Your Game</a>
                </div>
                <div>
                    <form id="user-signout" method="POST">
                        <button type="submit" class="btn btn-outline-primary">Sign Out</a>
                    </form>
                </div>
                `)
            } else {
                document.write(`
                <div>
                    <a href="/">Home</a>
                </div>
                <div>
                    <a href="/user/signup" class="btn btn-outline-dark">Sign Up</a>
                    <a href="/user/signin" class="btn btn-dark">Signin</a>
                </div>
                `)
            }

            // SignOut event
            $('#user-signout').on('submit', function(e) {
                e.preventDefault()
                $.ajax({
                    url: '/api/v1/user/signout',
                    method: 'POST',
                    data: {
                        user: user.id,
                        token: token,
                    },
                    success: function(response) {
                        localStorage.clear()
                        var user = null
                        var token = null
                        window.location.href = '/'
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            })
        </script>
    </nav>

    <main class="container">
        @yield('content')
    </main>


</body>

</html>
