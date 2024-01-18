@extends('layout.app')


@section('page-link', '/')
@section('page-title', 'Pertanyaan')
@section('sub-page-title', 'Index')

@section('content')
    <x-util.card title="Pertanyaan" add url="{{route('admin.test.question.create', $subjectTest->id)}}">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Question</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Action</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Notes</th>
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-util.card>
@endsection

@section('custom-footer')
<x-datatables.single url="{{route('admin.test.question.index', $subjectTest->id)}}">
    <x-datatables.column name="question"/>
    <x-datatables.action />
    <x-datatables.column name="notes"/>
</x-datatables.single>
@endsection
