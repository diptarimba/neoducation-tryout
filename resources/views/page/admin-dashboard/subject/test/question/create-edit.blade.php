@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Pertanyaan')
@section('sub-page-title', 'Form')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="question" label="Pertanyaan" placeholder="input subject name"
                value="{{ $question->question ?? '' }}" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection
