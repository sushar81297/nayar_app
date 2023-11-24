@extends('layouts.app')

@section('content')
<section class="content">
    <div class="row justify-content-end">
        <div class="col-lg-4">
            <div class="input-group input-group-outline">
                <input type="date" class="form-control" name="searchDate">
            </div>
        </div>
        <div class="col-lg-2">
            <a href="{{ route('page_post') }}">
                <button class="btn btn-outline-primary btn-sm mb-0 me-3">Create Post</button>
            </a>
        </div>
    </div>
    @forelse ($posts as $post)
    <div class="col-lg-8 col-md-6 mb-4">
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
                <img src="{{$post->image}}" width="400px" />
                @endif
            </div>
        </div>
    </div>
    @empty
    @endforelse
</section>
@endsection