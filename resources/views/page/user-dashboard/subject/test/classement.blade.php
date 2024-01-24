@extends('layout.app')


@section('page-link', route('user.test.index'))
@section('page-title', 'Classement')
@section('sub-page-title', 'List')

@section('content')
    <x-util.card title="{{$subjectTest->name}}">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Name</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Score</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-util.card>
@endsection

@section('custom-footer')
<x-datatables.single url="{{route('user.test.classement', $subjectTest->id)}}">
    <x-datatables.column name="user.name"/>
    <x-datatables.column name="score"/>
</x-datatables.single>
@endsection
