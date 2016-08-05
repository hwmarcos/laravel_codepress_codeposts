@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>Create Post</h3>
        <hr/>
        <form action="{{route('admin.posts.store')}}" method="post">
            <fieldset>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea name="content" id="mytiny" class="form-control"></textarea>
                    @include('tinymce::tpl')
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" name="enviar" value="Enviar">
                </div>
            </fieldset>
        </form>
    </div>

@endsection