@extends('layout.app')


@section('page-link', '/')
@section('page-title', 'Mata Ujian')
@section('sub-page-title', 'Index')

@section('content')
    <x-util.card title="Mata Ujian" add url="{{route('admin.test.create')}}">
        <div class="overflow-x-auto">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Name</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Start At</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Duration</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Jumlah Soal</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Enrolled Code</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Status</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Message</th>
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
<x-datatables.single url="{{route('admin.test.index')}}">
    <x-datatables.column name="name"/>
    <x-datatables.column name="start_at"/>
    <x-datatables.column name="duration"/>
    <x-datatables.column name="question_count"/>
    <x-datatables.column name="enrolled_code"/>
    <x-datatables.column name="status"/>
    <x-datatables.column name="message"/>
    <x-datatables.action />
</x-datatables.single>
@endsection
