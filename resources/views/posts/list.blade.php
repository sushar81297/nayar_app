@extends('layouts.app')

@section('content')
<section class="content">
  <div style="display: flex">
    <div class="col-lg-6">
      <div id="chart-container" style="height: 400px; padding-right:2px"></div>
    </div>
    <div class="col-lg-6">
      <div id="bar-chart-container" style="height: 400px; padding-left:2px"></div>
    </div>
  </div>
  <br>

  <div>
    @forelse ($posts as $post)
    <div class="post-container">
      <div class="post-header">
        <img src="https://placekitten.com/40/40" alt="Avatar" class="avatar">
        <div>
          <h6>John Doe <br>Posted on November 29, 2023</h6>
        </div>
      </div>
      <div class="post-content">
        <p>{{$post->message}}</p>
      </div>
      <div class="post-gallery">
        @if($post->images)
          @forelse ($post->images as $key => $value)
          <img src="{{$value}}" width="200px" />
          @empty
          @endforelse
          @elseif($post->image)
          <img src="{{$post->image}}" width="200px" />
        @endif
      </div>
      <div class="post-actions">
        <div class="post-action">
          <img src="{{asset('assets/img/like.png')}}" style="width: 16px;height:16px;" alt="">
          {{$post->Liked}}
        </div>
        <div class="post-action">
          <img src="{{asset('assets/img/love.png')}}" style="width: 16px;height:16px;" alt="">
          {{$post->Love}}
        </div>
        <div class="post-action">
          <img src="{{asset('assets/img/wow.png')}}" style="width: 16px;height:16px;" alt="">
          {{$post->Wow}}
        </div>
        <div class="post-action">
          <img src="{{asset('assets/img/sad.png')}}" style="width: 16px;height:16px;" alt="">
          {{$post->Sad}}
        </div>
        <div class="post-action">
          <img src="{{asset('assets/img/angry.png')}}" style="width: 16px;height:16px;" alt="">
          {{$post->Angry}}
        </div>
      </div>
    </div>
    @empty
    @endforelse
  </div>
  <!-- @forelse ($posts as $post)
  <div class="col-lg-12 col-md-6 mb-4">
    <div class="card">
      <div class="card-header">{{$post->message}}</div>
      <div class="card-body">
        <p>Total Like Count : <b>{{$post->likes}}</b> Total Comment Count : <b>{{$post->comments}}</b> </p>
        <p>Created Time : <b>{{$post->created_time}}</b></p>
        @if($post->images)
        @forelse ($post->images as $key => $value)
        <img src="{{$value}}" width="200px" />
        @empty
        @endforelse
        @elseif($post->image)
        <img src="{{$post->image}}" width="200px" />
        @endif
      </div>
    </div>
  </div>
  @empty
  @endforelse -->
</section>
<script>
  // Sample data for the chart
  var data = [5, 10, 15, 20, 25];

  // Create the chart
  Highcharts.chart('chart-container', {
    chart: {
      type: 'line' // Specify the chart type
    },
    title: {
      text: 'Simple Line Chart Demo'
    },
    xAxis: {
      categories: ['Category 1', 'Category 2', 'Category 3', 'Category 4', 'Category 5'] // X-axis labels
    },
    yAxis: {
      title: {
        text: 'Values' // Y-axis label
      }
    },
    series: [{
      name: 'Data Series',
      data: data // Actual data points
    }]
  });
  // Sample data for the bar chart
  var data = [5, 10, 15, 20, 25];

  // Create the bar chart
  Highcharts.chart('bar-chart-container', {
    chart: {
      type: 'bar' // Specify the chart type as a bar chart
    },
    title: {
      text: 'Highcharts Bar Chart Demo' // Chart title
    },
    xAxis: {
      categories: ['Category 1', 'Category 2', 'Category 3', 'Category 4', 'Category 5'], // X-axis labels
      title: {
        text: 'Categories' // X-axis title
      }
    },
    yAxis: {
      title: {
        text: 'Values' // Y-axis title
      }
    },
    series: [{
      name: 'Data Series',
      data: data // Actual data points for the bar chart
    }]
  });
</script>
@endsection