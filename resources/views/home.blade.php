@extends('layouts.app')

@section('content')
<section class="content">
    <div class="row">
      @forelse ($pages as $page)
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card" style="height:253px;">
            <div class="card-body b-t collapse show " style="padding:0.5rem !important;">
                <div> 
                    <div class="profile-header-container" style="height:150px;">
                        <div class="profile-header-img">
                          <img class="img-circle" style="width:100px;"src="{{$page->image_url}}">
                          <a href="/page_post/{{$page->page_id}}"><label for="" style="font-weight:700;padding:7px;min-width:105px;">{{$page->page_name}}</label></a>
                        </div>
                    </div> 
                    <div style="text-align:center;">
                        <a href="/page_post/{{$page->page_id}}"><label style="padding:5px;background-color: rgb(81, 210, 183);font-size: 13px;color: white;width:76px;">
                          Detail
                        </label></a>
                    </div>
                </div>
            </div>
        </div>
      </div>
      @empty
      @endforelse
      </div>
</section>
@endsection
