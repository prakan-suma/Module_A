@extends('main')

@section('content')
    {{session('mess')}}
    <div>
        <h4>Games</h4>
    </div>
    <div class="row my-5" id="games">

    </div>
    {{-- script  --}}
    <script>
        log(user)
        $(document).ready(() => {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/games',
                type: 'GET',
                success: (response) => {
                    if (response.game.length > 0) {
                        var html = '';
                        $.each(response.game, function(g, game) {
                            const data = response.game[g];
                            html += `
                            <div class="card col m-2">
                                <img class="card-img-top" id="thumbnail" src="{{ asset('images/thumbnails/${data.thumbnail}') }}" alt="Image" height="200">
                                <div class="card-body">
                                    <h5 class="card-title">${data.title}</h5>
                                    <p class="card-text">${data.description}</p>
                                    <p class="card-text">${data.user.username}</p>
                                    <p class="card-text">${data.current_version.created_at}</p>
                                </div>`;

                                // Check userStatus
                                if (token !== null){
                                     html += `<div class="card-body">
                                        <a href="/game/${data.current_version.files}" class="btn-sm btn-dark mx-0">Play</a>
                                        </div>`
                                    };
                                html += `</div>`
                                })
                        $('#games').html(html)

                    }
                }
            })
        })
    </script>
@endsection
