@extends('layout.app')


@section('page-link', '/')
@section('page-title', 'Siswa Terdaftar')
@section('sub-page-title', 'Index')

@section('content')
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
<x-datatables.single url="{{route('admin.user.index')}}">
    <x-datatables.column name="name"/>
    <x-datatables.column name="phone"/>
    <x-datatables.column name="school"/>
    <x-datatables.column name="registered_at"/>
    <x-datatables.action />
</x-datatables.single>
@endsection
