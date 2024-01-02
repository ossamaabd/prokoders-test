<!DOCTYPE html>
<html>
<head>
  <title>Star Admin Pro Laravel Dashboard Template</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

  <!-- plugin css -->
  {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
  {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}
  <!-- end plugin css -->

  @stack('plugin-styles')

  <!-- common css -->
  {!! Html::style('css/app.css') !!}
  {!! Html::style('css/animate.min.css') !!}
  <!-- end common css -->

  @stack('style')
</head>
<body data-base-url="{{url('/')}}">
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if(isset($alertMessages))

    @foreach($alertMessages as $alertMessage)
    <script>

              Swal.fire({
            title: '{{ $alertMessage['title'] }}',
            text: '{{ $alertMessage['text'] }}',
            icon: '{{ $alertMessage['icon'] }}',
            showCloseButton: {{ $alertMessage['showCloseButton'] ? 'true' : 'false' }},
            showDenyButton: {{ $alertMessage['show_deny_button'] ? 'true' : 'false' }},
            showCancelButton: {{ $alertMessage['show_cancel_button'] ? 'true' : 'false' }},
            showClass: {
                popup:
            '{{$alertMessage['animated'] == 1 ? 'animate__animated animate__fadeInDown' : '' }}',
            },
            position: '{{ $alertMessage['position'] }}'
        });
    </script>
@endforeach
@endif
  <div class="container-scroller" id="app">
    @include('layout.header')
    <div class="container-fluid page-body-wrapper">
      @include('layout.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        @include('layout.footer')
      </div>
    </div>
  </div>

  <!-- base js -->
  {!! Html::script('js/app.js') !!}
  {!! Html::script('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') !!}
  <!-- end base js -->

  <!-- plugin js -->
  @stack('plugin-scripts')
  <!-- end plugin js -->

  <!-- common js -->
  {!! Html::script('assets/js/off-canvas.js') !!}
  {!! Html::script('assets/js/hoverable-collapse.js') !!}
  {!! Html::script('assets/js/misc.js') !!}
  {!! Html::script('assets/js/settings.js') !!}
  {!! Html::script('assets/js/todolist.js') !!}
  <!-- end common js -->

  @stack('custom-scripts')
</body>


</html>
