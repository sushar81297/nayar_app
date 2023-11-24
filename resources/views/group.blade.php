@extends('layouts.app')

@section('content')
<section class="content">
  <div class="row">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>No</th>
                <th>Group Name</th>
              </thead>
              @forelse ($groups as $i => $group)
              <tbody>
                <tr>
                  <td>{{$i+1}}</td>
                  <td>
                    <span class="text-xs font-weight-bold">{{$group->group_name}}</span>
                  </td>
                </tr>
              </tbody>
              @empty
              @endforelse
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection