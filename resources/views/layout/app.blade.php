@extends('layout.base-layout')

@section('base-content')
    <div class="page-content dark:bg-zinc-700">
        <div class="container-fluid px-[0.625rem]">
            @if (session('success'))
                <x-util.alert color="green" message="{{ session('success') }}" />
            @endif

            @if (session('error'))
                <x-util.alert color="red" message="{{ session('error') }}" />
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-util.alert color="red" message="{{ $error }}" />
                @endforeach
            @endif

            <x-util.breadcrumb />
            @yield('content')
        </div>
    </div>
@endsection
