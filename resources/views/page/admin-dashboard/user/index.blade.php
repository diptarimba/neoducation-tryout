@extends('layout.app')


@section('page-link', '/')
@section('page-title', 'Siswa Terdaftar')
@section('sub-page-title', 'Index')

@push('additional-header')
    <style>
        .dt-buttons {
            justify-content: end;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        @media screen and (max-width: 767px) {

            .dt-buttons {
                justify-content: center;
            }
        }

        .dt-buttons button:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
    </style>
@endpush

@section('content')
<div class="grid grid-cols-6 gap-4">
    {{-- <div class="col-start-5 col-end-7"> --}}
        <input type="text"
            class="w-full rounded mb-2 border-gray-100 placeholder:text-sm focus:border focus:border-violet-500 focus:ring-0 dark:bg-zinc-700/50 dark:border-zinc-600 dark:placeholder:text-zinc-100 dark:text-zinc-100"
            name="daterange" value="01/01/2018 - 01/15/2018" />
    {{-- </div> --}}
</div>
    <x-util.card title="Siswa Terdaftar">
        <div class="overflow-x-auto">
            <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
                <thead>
                    <tr>
                        <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                        <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Name</th>
                        <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Phone</th>
                        <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">School</th>
                        <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Registered At</th>
                        <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Action</th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-util.card>
@endsection

@section('custom-footer')
<x-datatables.single needrange="betul" url="{{route('admin.user.index')}}">
    <x-datatables.column name="name"/>
    <x-datatables.column name="phone"/>
    <x-datatables.column name="school"/>
    <x-datatables.column name="registered_at"/>
    <x-datatables.action />
</x-datatables.single>
@endsection
