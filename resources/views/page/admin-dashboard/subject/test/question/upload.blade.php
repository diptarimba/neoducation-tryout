@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Membuat Pertanyaan')
@section('sub-page-title', 'Form')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <div class="mb-2">
                <a href="{{asset('assets-dashboard/file/ExQuestion.xlsx')}}?mime=application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" download><button type="button" class="btn text-violet-500 hover:text-white border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:text-white focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600">Download Contoh File</button></a>
            </div>
            <x-form.input type="file" name="file" label="" placeholder=""
                value="" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection

@section('custom-footer')
@endsection

