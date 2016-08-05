@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>Posts</h3>

        <br>
        <a href="{{route('admin.posts.create')}}" class="btn btn-default">Create Post</a>

        <table class="table table-bordered table-condensed table-striped table-hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>Title</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->title}}</td>
                    <td>
                        <a name="link_edit_post_{{$post->id}}" href="{{route('admin.posts.edit', ['id'=>$post->id])}}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

@endsection