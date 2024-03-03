@props(['beforeTest' => null])
@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Subject Test')
@section('sub-page-title', 'Form')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="name" label="Name" placeholder="input subject name"
            value="{{ $subjectTest->name ?? '' }}" />
            <x-form.input disable="{{ is_null($beforeTest) ?'': 'disable'}}" name="start_at" type="datetime-local" label="Start At" placeholder="choose when the test start"
                value="{{ isset($subjectTest->start_at) ? $subjectTest->start_at : '' }}" />
            <x-form.input disable="{{ is_null($beforeTest) ?'': 'disable'}}" name="end_at" type="datetime-local" label="End At" placeholder="choose when the test end"
                value="{{ isset($subjectTest->end_at) ? $subjectTest->end_at :  '' }}" />
            <x-form.input oninput="this.value = this.value.replace(/\s/g, '');" name="enrolled_code" label="Enrolled Code" placeholder="input enrolled code"
                value="{{ $subjectTest->enrolled_code ?? strtoupper(\Illuminate\Support\Str::random(8)) }}" />
            <x-form.select name="subject_id" title="Choose The Subject" data="{!! $subject !!}"
                value="{{ $subjectTest->subject_id ?? '' }}" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection

@section('custom-footer')
<script>
    console.log(moment().format('YYYY-MM-DD, HH:mm'))
    function validateTestTimes() {
        const startAtInput = document.querySelector('input[name="start_at"]');
        const endAtInput = document.querySelector('input[name="end_at"]');
        // startAtInput.setAttribute("min", moment().format('YYYY-MM-DD HH:mm'))
        // endAtInput.setAttribute("min", moment().format('YYYY-MM-DD HH:mm'))
        const now = new Date();
        const minimumInterval = 5 * 60 * 1000; // 5 minutes in milliseconds

        startAtInput.addEventListener('change', function() {
            const startTime = new Date(this.value);
            if (startTime < now) {
                alert('Start time cannot be less than the current time.');
                this.value = moment().format('YYYY-MM-DD HH:mm');
            }
        });

        endAtInput.addEventListener('change', function() {
            const endTime = new Date(this.value);
            const startTime = new Date(startAtInput.value);
            console.log('waktu pertama :', startTime)
            if (endTime <= startTime) {
                alert('End time must be greater than start time.');
                this.value = moment(startTime).add(5, 'minutes').format('YYYY-MM-DD HH:mm');
            } else if (endTime - startTime < minimumInterval) {
                alert('End time must be at least 5 minutes greater than start time.');
                console.log("ini", new Date(startTime.getTime() + minimumInterval).toISOString().slice(0, 16))
                this.value = moment(startTime).add(5, 'minutes').format('YYYY-MM-DD HH:mm');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', validateTestTimes);
</script>
@endsection
