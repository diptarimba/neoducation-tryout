@extends('layout.app')

@section('page-link', '/')
@section('page-title', 'Dashboard')
@section('sub-page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    <x-home.card-mini title="Transaksi Kemarin" prefix="" counterValue="{{number_format($amountYesterday, 0, ',', '.')}}" suffix="" color="red" valueChanged="{{$percentageIncreaseYesterday}}" information="Since last week"/>
    <x-home.card-mini title="Transaksi Hari ini" prefix="" counterValue="{{number_format($amount, 0, ',', '.')}}" suffix="" color="green" valueChanged="{{$percentageIncreaseToday}}" information="Since last week"/>
    <x-home.card-mini title="Transaksi Bulan Ini" prefix="" counterValue="{{number_format($amountMonth, 0, ',', '.')}}" suffix="" color="green" valueChanged="{{$percentageIncreaseMonth}}" information="Since last month"/>
</div>
@endsection
