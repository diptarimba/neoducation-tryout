@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'User')
@section('sub-page-title', 'Data')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="name" label="Name" placeholder="input your name" value="{{ $user->name ?? '' }}" />
            <x-form.input name="password" type="password" label="Password" placeholder="input your name"
                value="{{ '' }}" />
            <x-form.input oninput="this.value = this.value.replace(/^[._]+|[._]+$|[^0-9_.]/g, '');" name="phone" label="Phone" placeholder="input phone"
                value="{{ $user->phone ?? '' }}" />
            <x-form.input oninput="this.value = this.value.replace(/^[._]+|[._]+$|[^A-Za-z0-9_.]/g, '')" name="username" label="Username" placeholder="input your nim"
                value="{{ $user->username ?? '' }}" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection
