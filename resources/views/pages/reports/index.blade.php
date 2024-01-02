@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <h4 class="card-title mb-0">reports</h4>
      </div>
      <div class="card-body">


        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"></h4>
                <p class="card-description">  <code></code> </p>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>  </th>
                        <th> Name </th>
                        <th> Phone Number </th>
                        <th> Email </th>
                        <th> date </th>
                        <th>  </th>
                        <th>  </th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($shops as $shop)


                      <tr>
                        <td>

                            <img class="img-sm rounded-circle mb-4 mb-md-0 d-block mx-md-auto" src="/image_shop/{{$shop->photo}}" alt="profile image">
                        </td>

                        <td class="py-1">
                          {{$shop->name}} </td>
                        <td> {{$shop->description}} </td>
                        <td> {{$shop->phone_number}} </td>
                        <td>
                          {{$shop->created_at}}
                        </td>
                        <td>  </td>
                        <td>
                            <a href="" class="ma-4">
                                <i class="mdi mdi-window-close" style="color:red; font-size:22px;"></i>
                            </a>

                            <a href="" class="pa-4">
                                <i class="mdi mdi-checkbox-marked-circle-outline" style="font-size: 22px;"></i>
                            </a>


                        </td>
                      </tr>
                      @empty
                      don't have any users
                      @endforelse

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>



      </div>
    </div>
  </div>

</div>
@endsection

@push('plugin-scripts')
  {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
@endpush

@push('custom-scripts')
  {!! Html::script('/assets/js/chart.js') !!}
@endpush
