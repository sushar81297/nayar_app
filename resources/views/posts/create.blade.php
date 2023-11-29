@extends('layouts.app')

@section('content')
<section class="content">
  <div class="col-lg-12 col-md-6 mb-4">
    <div class="card">
      <div class="card-header">Create Post</div>
      <div class="card-body">
        <form class="text-start" action="{{ route('post.store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="text" hidden value="{{$page_id}}" class="form-control" name="page_id">
          @csrf
          <input type="text" hidden value="{{$page_id}}" class="form-control" name="page_id">
          <label>Content</label>
          <div class="input-group input-group-outline my-3">
            {{-- <input type="text" class="form-control" name="message"> --}}
            <textarea name="" id="" cols="100" rows="10" class="form-control"></textarea>
          </div>
          <label>Upload Image</label><br>
          <img src="https://via.placeholder.com/200x200" alt="">
          <div class="input-group input-group-outline mb-3 mt-2">
            <input type="file" name="file" id="file" multiple />
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
            <label class="form-check-label" for="flexCheckDefault">
              Select All
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
            <label class="form-check-label" for="flexCheckChecked">
              Category 1
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
            <label class="form-check-label" for="flexCheckDefault">
              Category 2
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
            <label class="form-check-label" for="flexCheckChecked">
              Category 3
            </label>
          </div>
          <div class="text-center">
            <button type="submit" class="btn bg-gradient-primary w-20 my-4 mb-2">Create Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection