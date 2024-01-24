@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', $data['title'])
@section('sub-page-title', 'Index')


@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-button.submit label="Mulai Test" />
        </x-form.base>
    </x-util.card>
@endsection
