@extends('layouts.app')

@section('content')
<section class="content">
    <div class="row justify-content-end">
        <div class="col-lg-6">
            <b class="control-label">{{$page_name}}</b>
        </div>
        <div class="col-lg-4">
            <div class="input-group input-group-outline">
                <input type="date" class="form-control" name="searchDate">
            </div>
        </div>
        <div class="col-lg-2">
            <a href="{{ route('post_create', $page_id) }}">
                <button class="btn btn-outline-primary btn-sm mb-0 me-3">Create Post</button>
            </a>
        </div>
    </div>
    @forelse ($posts as $post)
    <div class="col-lg-12 col-md-6 mb-4">
        <div class="card">
            <div class="card-header">{{$post->message}}</div>
            <div class="card-body">
                <p>Total Like Count : <b>{{$post->likes}}</b> Total Comment Count : <b>{{$post->comments}}</b> </p>
                <p>Created Time : <b>{{$post->created_time}}</b></p>
                @if($post->images)
                    @forelse ($post->images as $key => $value)
                        <img src="{{$value}}" width="200px"/>
                    @empty
                    @endforelse
                @elseif($post->image)
                <img src="{{$post->image}}" width="200px" />
                @endif
                <br>
                <a href="/post/delete/{{$post->post_id}}" type="button" class="btn btn-danger btn-xs">Delete</a>
            </div>
        </div>
    </div>
    @empty
    @endforelse
</section>
@endsection