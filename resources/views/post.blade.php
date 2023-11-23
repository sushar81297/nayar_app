@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                        <p>Total Like Count : <b>{{$post->likes}}</b> Total Comment Count : <b>{{$post->comments}}</b> </p>
                        <div>{{optional($post)->message }}</div>
                        <br>
                        <hr>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection