@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>Edit Post</h3>
        <hr/>
        <form action="{{route('admin.posts.update')}}" method="post">
            <fieldset>
                <input type="hidden" name="id" value="{{$post->id}}">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" class="form-control" value="{{$post->title}}">
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea name="content" id="mytiny" class="form-control">{{$post->content}}</textarea>
                    @include('tinymce::tpl')
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" name="enviar" value="Enviar">
                </div>
            </fieldset>
        </form>
    </div>

@endsection