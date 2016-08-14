@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>Posts</h3>

        <br>
        <a href="{{route('admin.posts.index')}}" class="btn btn-default">Posts List</a>

        <table class="table table-bordered table-condensed table-striped table-hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>Title</td>
                <td>Deleted At</td>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->title}}</td>
                    <td>
                        {{$post->deleted_at}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

@endsection