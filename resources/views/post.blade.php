@extends('layouts.app')

@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">{{$page_name}} Posts</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif 
            @forelse ($posts as $post)
                <p>Created Time : <b>{{$post->created_time}}</b></p>
                @if($post->images)
                    @forelse ($post->images as $key => $value)
                        <img src="{{$value}}" width="400px"/>
                    @empty
                    @endforelse
                @elseif($post->image)
                <img src="{{$post->image}}" width="400px" />
                @endif
                <p>Total Like Count : <b>{{$post->likes}}</b> Total Comment Count : <b>{{$post->comments}}</b> </p>
                <div>{{optional($post)->message }}</div>
                <br>
                <hr>
            @empty
            @endforelse
        </div>
    </div>
</section>
@endsection