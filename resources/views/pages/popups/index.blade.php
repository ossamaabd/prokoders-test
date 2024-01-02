@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="p-4 border-bottom bg-light">
                    <h4 class="card-title mb-0">Teachers</h4>
                </div>
                <div class="card-body">


                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <p class="card-description"> add new popup <a href="/popups/ViewAddPopup"><button
                                            class="btn btn-success "> Add Popup </button></a> </p>
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <tr>

                                                <th> Popup id </th>
                                                <th> title </th>
                                                <th> text </th>
                                                <th> icon </th>
                                                <th> show_deny_button </th>
                                                <th> show_cancel_button </th>
                                                <th> position </th>
                                                <th> animated </th>
                                                <th> date </th>
                                                <th> </th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($Popups as $Popup)
                                                <tr>
                                                    <td>

                                                        {{ $Popup->id }}
                                                    </td>

                                                    <td class="py-1">
                                                        {{ $Popup->title }} </td>
                                                    <td> {{ $Popup->text }} </td>
                                                    <td> {{ $Popup->icon }} </td>
                                                    <td> {{ $Popup->show_deny_button == 1 ? 'yes' : 'no' }} </td>
                                                    <td> {{ $Popup->show_cancel_button == 1 ? 'yes' : 'no' }} </td>
                                                    <td> {{ $Popup->position }} </td>
                                                    <td> {{ $Popup->animated == 1 ? 'yes' : 'no' }} </td>
                                                    <td>
                                                        {{ $Popup->created_at }}
                                                    </td>
                                                    <td> </td>
                                                    <td>

                                                        <button type="button" class="btn btn-success testing">
                                                            test
                                                        </button>

                                                       <a href="/popups/ViewEditPopup/{{$Popup->id}}">
                                                        <button type="button" class="btn btn-warning">
                                                            edit
                                                        </button>
                                                       </a>
                                                       <a href="/popup_pages/index/{{$Popup->id}}">
                                                        <button type="button" class="btn btn-success">
                                                            Popup pages
                                                        </button>
                                                       </a>


                                                    </td>
                                                </tr>
                                            @empty
                                                don't have any files
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
<script src="{{ asset('/js/jquery.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {



        $("#myTable").on('click', '.testing', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }

            });
            // get the current row
            var currentRow = $(this).closest("tr");
            var popupId = currentRow.find("td:eq(0)").text(); // get current row 3rd TD


            $.ajax({
                url: "{{ route('popups.getPopupById') }}",
                data: {
                    popupId: popupId

                },
                type: "GET",
                success: function(response) {
                    JSON.stringify(response);
                    console.log(response);
                    console.log(response.data);
                    console.log(response.data.animated);
                    let showClass = "";

                    if (response.data.animated == 1) {
                        showClass = "animate__animated animate__fadeInDown";
                    }
                    console.log(showClass)

                    Swal.fire({
                        title: response.data.title,
                        text: response.data.text,
                        icon: response.data.icon,
                        showCloseButton: (response.data.showCloseButton) ? true :
                            false,
                        showDenyButton: (response.data.show_deny_button) ? true :
                            false,
                        showCancelButton: (response.data.show_cancel_button) ?
                            true : false,
                        showClass: {
                            popup: showClass
                        },
                        position: response.data.position


                    })

                },
                error: function(xhr, status, error) {

                    $('.loading').css('display', 'none');

                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    swal(xhr.responseJSON.message);

                }

            });


        });


    });
</script>
