@extends('layouts.base')

@section('body')
    @include('layouts.header')

    <main class="wrap">
            @yield('content')
    </main>

@endsection