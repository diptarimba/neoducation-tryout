@extends('layout.app')

@section('page-link', '/')
@section('page-title', 'Dashboard')
@section('sub-page-title', 'Index')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
    <x-home.card-mini title="Siswa" prefix="" counterValue="{{number_format($student, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $20.9k" information="Since last week"/>
    <x-home.card-mini title="Mata Pelajaran" prefix="" counterValue="{{number_format($subject, 0, ',', '.')}}" suffix="" color="red" valueChanged="- 29 Trades" information="Since last week"/>
    <x-home.card-mini title="Test" prefix="" counterValue="{{number_format($test, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $2.8k" information="Since last week"/>
</div>
@endsection
