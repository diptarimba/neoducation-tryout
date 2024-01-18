@extends('layout.app')


@section('page-link', '/')
@section('page-title', 'Jawaban')
@section('sub-page-title', 'Index')

@section('content')
    <x-util.card title="Jawaban" add url="{{route('admin.test.answer.create', [$subjectTest->id, $question->id])}}">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Answer</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Correct</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Action</th>
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-util.card>
@endsection

@section('custom-footer')
<x-datatables.single url="{{route('admin.test.answer.index', [$subjectTest->id, $question->id])}}">
    <x-datatables.column name="answer"/>
    <x-datatables.column name="is_true"/>
    <x-datatables.action />
</x-datatables.single>
@endsection