@extends('layout.app')


@section('page-link', route('merchant.cashout.index'))
@section('page-title', 'Transaction')
@section('sub-page-title', 'List')

@section('content')
    <x-util.card title="List" add url="{{route('merchant.cashout.create')}}" custom-text="Request">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Jumlah (Rp. )</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-util.card>
@endsection

@section('custom-footer')
<x-datatables.single url="{{route('merchant.cashout.index')}}">
    <x-datatables.column name="amount"/>
    <x-datatables.column name="status"/>
</x-datatables.single>
@endsection
