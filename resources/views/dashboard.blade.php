@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
  
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif 
                    @forelse ($pages as $page)
                        <a href="/page_post/{{$page->page_id}}">{{$page->page_name}}</a>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection