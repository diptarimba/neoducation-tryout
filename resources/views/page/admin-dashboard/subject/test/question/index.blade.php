@extends('layout.app')


@section('page-link', '/')
@section('page-title', 'Pertanyaan')
@section('sub-page-title', 'Index')

@section('content')
    <x-button.cancel colour="green" type="back" url="{{route('admin.test.index')}}" label="Back" />
    <x-util.card title="{{$subjectTest->name}}">
        @if ($duringTest)
            <x-slot name="customBtn">
                <button onclick="delete_data('delete_all')"
                    class="btn m-1 text-white bg-red-500 border-red-500 hover:bg-red-600 hover:border-red-600 focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-500/30 active:bg-red-600 active:border-red-600">Delete
                    All</button>
                <a href="{{ route('admin.test.question.upload.index', $subjectTest->id) }}"><button
                        class="btn m-1 text-white bg-green-500 border-green-500 hover:bg-green-600 hover:border-green-600 focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-500/30 active:bg-green-600 active:border-green-600">Upload</button></a>
                <a href="{{ route('admin.test.question.create', $subjectTest->id) }}"><button
                        class="btn m-1 text-white bg-green-500 border-green-500 hover:bg-green-600 hover:border-green-600 focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-500/30 active:bg-green-600 active:border-green-600">Add
                        Data</button></a>
            </x-slot name="customBtn">
        @endif

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
        <form action="{{ route('admin.test.question.destroy.all', $subjectTest->id) }}" id="delete_all" method="post">
            @csrf
        </form>
    </x-util.card>
@endsection

@section('custom-footer')
    <x-datatables.single url="{{ route('admin.test.question.index', $subjectTest->id) }}">
        <x-datatables.column name="question" />
        <x-datatables.action />
        <x-datatables.column name="notes" />
    </x-datatables.single>
@endsection
