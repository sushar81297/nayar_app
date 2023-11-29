@extends('layouts.app')

@section('content')
<section class="content">
  <div class="col-lg-12 col-md-6 mb-4">
    <div class="card">
      <div class="card-header">Create Post</div>
      <div class="card-body">
        <form class="text-start" action="{{ route('post.store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
          @csrf
          <label>Content</label>
          <div class="input-group input-group-outline my-3">
            <textarea name="" id="" cols="100" rows="10" class="form-control"></textarea>
          </div>
          <label>Upload Image</label><br>
          <div id="preview" class="mt-1">
            <img src="https://via.placeholder.com/200x200" alt="">
        </div>
          <div class="input-group input-group-outline mb-3 mt-2">
            <input type="file" name="file" id="file"/>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onclick='selects()' value="Select All">
            <label class="form-check-label" for="flexCheckDefault">
              Select All
            </label>
          </div>
          @forelse ($pages as $key => $page)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
            <label class="form-check-label" for="flexCheckChecked">
              {{$page->page_name}}
            </label>
          </div>
          @empty
          @endforelse
          <div class="text-center">
            <button type="submit" class="btn bg-gradient-primary w-20 my-4 mb-2">Create Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  function selects() {
    var ele = document.getElementsByName('chk');
    for (var i = 0; i < ele.length; i++) {
      if (ele[i].type == 'checkbox')
        ele[i].checked = true;
    }
  }

  function deSelect() {
    var ele = document.getElementsByName('chk');
    for (var i = 0; i < ele.length; i++) {
      if (ele[i].type == 'checkbox')
        ele[i].checked = false;

    }
  }

  function imagePreview(fileInput) {
    if (fileInput.files && fileInput.files[0]) {
      var fileReader = new FileReader();
      fileReader.onload = function(event) {
        $('#preview').html('<img src="' + event.target.result + '" width="200" height="auto"/>');
      };
      fileReader.readAsDataURL(fileInput.files[0]);
    }
  }
  $("#file").change(function() {
    imagePreview(this);
  });
</script>
@endsection