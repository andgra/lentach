<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('css/import.css')."?t=".time() }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css')."?t=".time() }}">

  @yield('css')

  @isset($arrCss)
  @foreach ($arrCss as $css)
    <link rel="stylesheet" type="text/css" href="{{ asset($css)."?t=".time() }}">
  @endforeach
  @endisset
</head>

<body>
<div id="body">
  @yield('body')

</div>

@yield('modals')

<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="{{ asset('js/app.js')."?t=".time() }}"></script>


@isset($arrJs)
@foreach ($arrJs as $js)
  <script src="{{ asset($js)."?t=".time() }}"></script>
@endforeach
@endisset

@yield('js')


</body>
</html>
