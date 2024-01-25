@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Mata Pelajaran')
@section('sub-page-title', 'List')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input disable name="name" label="Nama" placeholder="input user name" value="{{ $user->name ?? '' }}" />
            <x-form.input disable name="username" label="Username" placeholder="input user name"
                value="{{ $user->username ?? '' }}" />
            <x-form.input disable name="school" label="Sekolah" placeholder="input user name"
                value="{{ $user->school ?? '' }}" />
            <x-form.input disable name="dob" label="Tanggal lahir" type="date" placeholder="input user name"
                value="{{ $user->dob ?? '' }}" />
            <x-form.input disable name="phone" label="No. Hp" placeholder="input user name"
                value="{{ $user->phone ?? '' }}" />
            <x-button.submit label="Reset Password" />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection
