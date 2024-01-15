@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Subject Test')
@section('sub-page-title', 'Form')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="name" label="Name" placeholder="input subject name"
                value="{{ $subjectTest->name ?? '' }}" />
            <x-form.input type="datetime-local" name="start_at" label="Start At" placeholder="choose when the test start"
                value="{{ $subjectTest->name ?? '' }}" />
            <x-form.input type="datetime-local" name="end_at" label="End At" placeholder="choose when the test end"
                value="{{ $subjectTest->name ?? '' }}" />
            <x-form.input name="enrolled_code" label="Enrolled Code" placeholder="input enrolled code"
                value="{{ $subjectTest->name ?? '' }}" />
            <x-form.select name="subject_id" title="Choose The Subject" data="{!! $subject !!}"
                value="{{ $subjectTest->subject_id ?? '' }}" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection
