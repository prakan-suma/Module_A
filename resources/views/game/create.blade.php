@extends('main')
@section('content')
    <div>
        <h4>Create Game</h4>
    </div>
    <form id="game" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group col">
                <label>Title *</label>
                <input name="title" type="text" class="form-control">
            </div>
            <div class="form-group col">
                <label>Slug *</label>
                <input name="slug" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>Description *</label>
            <textarea name="description" type="text" class="form-control"></textarea>
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
        $('#game').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('user', user);
            formData.append('token', token);

            $.ajax({
                url : '/api/v1/games',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response)
                },
                error: function(error) {
                    alert(JSON.parse(error))
                }
            })
        })
    </script>
@endsection
