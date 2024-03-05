@extends('layout.app')


@section('page-link', '/')
@section('page-title', 'Peserta Tes')
@section('sub-page-title', 'Index')

@section('content')
    <x-util.card title="Peserta Tes">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Name</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Score</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Waktu Selesai</th>
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-util.card>
@endsection

@section('custom-footer')
    <x-datatables.single url="{{ route('admin.test.user.index', $subjectTest->id) }}">
        <x-datatables.column name="user.name" />
        <x-datatables.column name="score" />
        <x-datatables.column name="end_at" />
        {{-- <x-datatables.action /> --}}
    </x-datatables.single>
@endsection
