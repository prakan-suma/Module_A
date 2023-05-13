@extends('main')
@section('content')
    <h4>Uploade the new version</h4>
    <form id="game_update" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group col">
                <label>Title *</label>
                <input name="id" type="hidden" class="form-control" value="{{ $game->id }}">
                <input readonly name="title" type="text" class="form-control" value="{{ $game->title }}">
            </div>
            <div class="form-group col">
                <label>Slug *</label>
                <input readonly name="slug" type="text" class="form-control" value="{{ $game->slug }}">
            </div>
        </div>
        <div class="form-group">
            <label>Description *</label>
            <textarea name="description" type="text" class="form-control">{{ $game->description }}</textarea>
        </div>
        <div class="form-group">
            <label>Thumnail *</label>
            <input name="thumbnail" type="file" class="form-control">
        </div>
        <div class="form-group">
            <label>File Game *</label>
            <input name="gamefile" type="file" class="form-control">
        </div>
        <button class="btn btn-primary my-4 col-3" type="submit">Upload</button>
    </form>

    <script>
        $('#game_update').on('submit', function(e) {
            e.preventDefault()
            var formData = new FormData(this)
            formData.append('user', user)
            formData.append('token', token)

            $.ajax({
                url: '/api/v1/games/update',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('success')
                },
                error: function(error) {
                    alert(error)
                }
            })
        })
    </script>
@endsection
