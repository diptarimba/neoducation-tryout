@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Subject Test')
@section('sub-page-title', 'Form')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="name" label="Name" placeholder="input subject name"
            value="{{ $subjectTest->name ?? '' }}" />
            <x-form.input name="start_at" type="datetime-local" label="Start At" placeholder="choose when the test start"
                value="{{ isset($subjectTest->start_at) ? date('Y-m-d H:i', $subjectTest->start_at ) : '' }}" />
            <x-form.input name="end_at" type="datetime-local" label="End At" placeholder="choose when the test end"
                value="{{ isset($subjectTest->end_at) ? date('Y-m-d H:i', $subjectTest->end_at) :  '' }}" />
            <x-form.input name="enrolled_code" label="Enrolled Code" placeholder="input enrolled code"
                value="{{ $subjectTest->enrolled_code ?? strtoupper(\Illuminate\Support\Str::random(8)) }}" />
            <x-form.select name="subject_id" title="Choose The Subject" data="{!! $subject !!}"
                value="{{ $subjectTest->subject_id ?? '' }}" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection
