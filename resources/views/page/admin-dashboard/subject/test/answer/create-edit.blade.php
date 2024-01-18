@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Subject Test')
@section('sub-page-title', 'Form')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="answer" label="Answer" placeholder="input the choice of the answers"
                value="{{ $answer->answer ?? '' }}" />
            <x-form.switch label="Is Correct?" name="is_true" {{!$answer->is_true ?: 'checked'}}/>
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection
