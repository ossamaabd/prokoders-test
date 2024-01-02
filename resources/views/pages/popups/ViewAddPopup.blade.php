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
                    <h4 class="card-title mb-0"></h4>
                </div>
                <div class="card-body">


                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <p class="card-description"> add Popup <code></code> </p>
                                <div class="table-responsive">

                                    <form action="/popups/create" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="title">title</label>
                                                <input  type="text" name="title"
                                                    class="form-control" id="title"
                                                    accept="image/jpeg, image/png, image/gif" required>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="text">text</label>
                                                <input type="text" name="text" class="form-control" id="text"
                                                    value="">
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="icon">icon select</label>
                                                <select style="height: 42px;" class="form-control" id="icon"
                                                    name="icon" required>
                                                    <option selected>success</option>
                                                    <option>warning</option>
                                                    <option>error</option>
                                                    <option>info</option>
                                                    <option>question</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="position">position select</label>
                                                <select style="height: 42px;" class="form-control" id="position"
                                                    name="position" required>
                                                    <option selected>center</option>
                                                    <option>top</option>
                                                    <option>top-end</option>
                                                    <option>top-start</option>
                                                    <option>center-end</option>
                                                    <option>bottom</option>
                                                    <option>bottom-end</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label class="" for="show_deny_button">show_deny_button</label>
                                                <input class="form-control" name="show_deny_button" type="checkbox"
                                                    id="show_deny_button"  aria-label="...">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="" for="show_cancel_button">show_cancel_button</label>
                                                <input class="form-control" name="show_cancel_button" type="checkbox"
                                                    id="show_cancel_button"  aria-label="...">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="" for="animated">animated</label>
                                                <input class="form-control" name="animated" type="checkbox"
                                                    id="animated"  aria-label="...">
                                            </div>

                                        </div>

                                        <button type="submit" class="btn btn-primary">add new Popup</button>
                                    </form>
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
