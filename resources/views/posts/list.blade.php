@extends('layouts.app')

@section('content')


<section class="content">
    <div style="display: flex">
        <div class="col-lg-6"><div id="chart-container" style="height: 400px; padding-right:2px"></div>
    </div>
        <div class="col-lg-6"><div id="bar-chart-container" style="height: 400px; padding-left:2px"></div>
    </div>

    </div>
<br>

<div style="display: flex">
    <div class="post-container">
        <div class="post-header">
          <img src="https://placekitten.com/40/40" alt="Avatar" class="avatar">
          <div><br>
            <h6>John Doe <br>Posted on November 29, 2023</h6>
          </div>
        </div>
        <div class="post-content">
          <p>This is a sample Facebook-like post. Lorem ipsum dolor sit amet, consectetur adipiscing elit... 🌟🐾</p>
        </div>
        <div class="post-gallery">
          <img src="https://placekitten.com/200/150" alt="Post Image 1" class="post-image">
          <img src="https://placekitten.com/200/150" alt="Post Image 2" class="post-image">
          <!-- Add more images as needed -->
        </div>
        <div class="post-actions">
          <div class="post-action">
            <img src="{{asset('assets/img/like.png')}}" style="width: 16px;height:16px;" alt="">
            1
          </div>
          <div class="post-action">
            <img src="{{asset('assets/img/love.png')}}" style="width: 16px;height:16px;" alt="">
            1
          </div>
          <div class="post-action">
            <img src="{{asset('assets/img/wow.png')}}" style="width: 16px;height:16px;" alt="">
            1
          </div>
          <div class="post-action">
            <img src="{{asset('assets/img/sad.png')}}" style="width: 16px;height:16px;" alt="">
            1
          </div>
          <div class="post-action">
            <img src="{{asset('assets/img/angry.png')}}" style="width: 16px;height:16px;" alt="">
            1
          </div>
        </div>
      </div>

  <div class="post-container">
    <div class="post-header">
      <img src="https://placekitten.com/40/40" alt="Avatar" class="avatar">
      <div><br>
        <h6>John Doe <br>Posted on November 29, 2023</h6>
      </div>
    </div>
    <div class="post-content">
      <p>This is a sample Facebook-like post. Lorem ipsum dolor sit amet, consectetur adipiscing elit... 🌟🐾</p>
    </div>
    <div class="post-gallery">
      <img src="https://placekitten.com/200/150" alt="Post Image 1" class="post-image">
      <img src="https://placekitten.com/200/150" alt="Post Image 2" class="post-image">
      <!-- Add more images as needed -->
    </div>
    <div class="post-actions">
      <div class="post-action">
        <img src="{{asset('assets/img/like.png')}}" style="width: 16px;height:16px;" alt="">
        1
      </div>
      <div class="post-action">
        <img src="{{asset('assets/img/love.png')}}" style="width: 16px;height:16px;" alt="">
        1
      </div>
      <div class="post-action">
        <img src="{{asset('assets/img/wow.png')}}" style="width: 16px;height:16px;" alt="">
        1
      </div>
      <div class="post-action">
        <img src="{{asset('assets/img/sad.png')}}" style="width: 16px;height:16px;" alt="">
        1
      </div>
      <div class="post-action">
        <img src="{{asset('assets/img/angry.png')}}" style="width: 16px;height:16px;" alt="">
        1
      </div>
    </div>
  </div>
</div>

    

    
    

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
{{-- facebook post style --}}
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .post-container {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 50%;
      padding: 20px;
      margin: 20px;
    }

    .post-header {
      display: flex;
      align-items: center;
    }

    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
      object-fit: cover;
    }

    .post-content {
      margin-top: 10px;
    }

    .post-gallery {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
      margin-top: 10px;
    }

    .post-image {
      width: 100%;
      height: auto;
      border-radius: 8px;
    }

    .post-actions {
      display: flex;
      margin-top: 10px;
    }

    .post-action {
      display: flex;
      align-items: center;
      margin-right: 10px;
      color: #606770;
      cursor: pointer;
    }

    .post-action i {
      margin-right: 5px;
    }
  </style>

{{-- chart script --}}
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
    </script>
    <script>
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

