@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Mata Pelajaran')
@section('sub-page-title', 'List')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="enrolled_code" label="Masukan Enrolled Code" placeholder="input enrolled code" value="" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection
