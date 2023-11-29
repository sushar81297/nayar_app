@extends('layouts.app')

@section('content')
<section class="content">
    <div class="col-lg-8 col-md-6 mb-4">
        <div class="card">
            <div class="card-header">Create Post</div>
            <div class="card-body">
            <form class="text-start" action="{{ route('post.store') }}" method="POST"
                    accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <input type="text" hidden value="{{$page_id}}" class="form-control" name="page_id">
                    <label>Description</label>
                    <div class="input-group input-group-outline my-3">
                        <input type="text" class="form-control" name="message">
                    </div>
                    <!-- <label>Upload Image</label>
                    <div class="input-group input-group-outline mb-3">
                        <input type="file" name="file" id="file" multiple />
                    </div> -->
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Create Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection