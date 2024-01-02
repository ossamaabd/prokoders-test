@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if(session()->has('message_worng'))
    <div class="alert alert-warning">
        {{ session()->get('message_worng') }}
    </div>
@endif

<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <h4 class="card-title mb-0"></h4>
      </div>
      <div class="card-body">


        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"></h4>
                <p class="card-description"> Popup title : {{$Popup->title}} <code></code> </p>
                <div class="table-responsive">

                    <form action="/popup_pages/assignPopupToPage">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"></h4>
                                    <p class="card-description"> assign popup to this page selected <a href="/popups/ViewAddPopup"><button
                                                class="btn btn-success "> Add Popup </button></a> </p>
                                    <div class="table-responsive">
                                        <table id="" class="table table-striped">
                                            <thead>
                                                <tr>

                                                    <th> page id </th>
                                                    <th> title </th>
                                                    <th> route </th>
                                                    <th> date </th>
                                                    <th> </th>
                                                    <th> </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($Popup->pages as $page)
                                                    <tr>
                                                        <td>

                                                            {{ $page->id }}
                                                        </td>

                                                        <td class="py-1">
                                                            {{ $page->title }} </td>
                                                        <td> {{ $page->route }} </td>
                                                        <td>
                                                            {{ $page->created_at }}
                                                        </td>
                                                        <td> </td>
                                                        <td>

                                                            <a href="/popup_pages/delete/{{$Popup->id}}/{{$page->id}}">
                                                            <button type="button" class="btn btn-danger">
                                                                delete
                                                            </button>
                                                        </a>

                                                        </td>
                                                    </tr>
                                                @empty
                                                    don't have any pages assigned to this popup
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">update student</button>
                      </form>


                </div>








                <div class="card-body">
                    <h4 class="card-title"></h4>
                    <p class="card-description"> assign popup to this page selected  </p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">search</label>
                            <input  type="text" name="search"
                                class="form-control" id="search"
                                >
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>

                                    <th> page id </th>
                                    <th> title </th>
                                    <th> route </th>
                                    <th> date </th>
                                    <th> </th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pages as $page)
                                    <tr>
                                        <td>

                                            {{ $page->id }}
                                        </td>

                                        <td class="py-1">
                                            {{ $page->title }} </td>
                                        <td> {{ $page->route }} </td>
                                        <td>
                                            {{ $page->created_at }}
                                        </td>
                                        <td> </td>
                                        <td>
                                            <a href="/popup_pages/assignPopupToPage/{{$Popup->id}}/{{$page->id}}">
                                            <button type="button" class="btn btn-success">
                                                assign
                                            </button>
                                        </a>


                                        </td>
                                    </tr>
                                @empty
                                    don't have any pages
                                @endforelse

                            </tbody>

                        </table>

                    </div>
                    <div class="pagination justify-content-center">
                        {{ $pages->links() }}
                    </div>
                </div>

              </div>

            </div>

          </div>



      </div>
    </div>
  </div>

</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('search');
    var table = document.getElementById('myTable');
    var rows = table.getElementsByTagName('tr');

    input.addEventListener('keyup', function() {
        var filter = input.value.toLowerCase();

        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var cells = row.getElementsByTagName('td');
            var found = false;

            for (var j = 0; j < cells.length && !found; j++) {
                var cell = cells[j];
                if (cell.innerText.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                }
            }

            row.style.display = found ? '' : 'none';
        }
    });
});
</script>
@push('plugin-scripts')
  {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
@endpush

@push('custom-scripts')
  {!! Html::script('/assets/js/chart.js') !!}
@endpush
