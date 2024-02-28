@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Upload File')
@section('sub-page-title', 'Form')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input type="file" name="file" label="Upload File Pertanyaan dan Jawaban" placeholder=""
                value="" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection

@section('custom-footer')
@endsection

