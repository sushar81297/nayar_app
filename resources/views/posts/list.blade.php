@extends('layouts.app')

@section('content')
<section class="content">
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
            </div>
        </div>
    </div>
    @empty
    @endforelse
</section>
@endsection