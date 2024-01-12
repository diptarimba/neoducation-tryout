@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'User')
@section('sub-page-title', 'Data')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input oninput="this.value = this.value.replace(/^[._]+|[._]+$|[^0-9_.]/g, '')" name="amount" type="number" label="Jumlah" placeholder="input the amount" value="" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection
