@extends('main')
@section('content')
    <h3>Your Game</h3>
    <table class="table table-border table-hover">
        <thead>
            <th>Title</th>
            <th>Slug</th>
            <th>Description</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Version</th>
            <th>&nbsp;</th>
        </thead>
        <tbody id="game-row">

        </tbody>
    </table>
    <script>
        $(document).ready(() => {
            log(user)
            $.ajax({
                url: "/api/v1/games/uploaded",
                type: "get",
                data: {
                    'user': user,
                    'token': token
                },
                success: (response) => {

                    if (response.game !== null) {
                        var html = '';
                        $.each(response.game, function(g, game) {
                            const data = response.game[g]

                            html += `
                            <tr>
                                <td>${data.title}</td>
                                <td>${data.slug}</td>
                                <td>${data.description}</td>
                                <td>${data.created_at}</td>
                                <td>${data.updated_at}</td>
                                <td>${data.current_version.created_at}</td>
                                <td><a class="btn btn-primary" href="/game/update/${data.slug}">Uploade New Version</a></td>
                            </tr>
                            `
                        });
                        $('#game-row').html(html);
                    } else {
                        alert('No data')
                    }
                },
                error: (error) => {
                    log(error)
                }
            })


        })
    </script>
@endsection
