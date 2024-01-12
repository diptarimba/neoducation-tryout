@section('custom-footer')
    <script>
        // mengambil URL saat ini
        let currentUrl = window.location.search;

        // membuat objek URLSearchParams dari URL saat ini
        var searchParams = new URLSearchParams(currentUrl);
        optionDatatables = {
            processing: true,
            serverSide: true,
            searching: true,
        }
        $(document).ready(() => {
            var table = $('.datatables-target-exec').DataTable({
                ...{
                    ajax: "{{ $url }}",
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600'
                    },
                    {{ $slot }}
                ]
                },
                ...optionDatatables
            });
        })
    </script>
@endsection

@push('additional-header')
     <!-- DataTables -->
     <link href="{{ asset('assets-dashboard/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('assets-dashboard/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

     <!-- Responsive datatable examples -->
     <link href="{{ asset('assets-dashboard/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('additional-footer')
    <!-- Required datatable js -->
    <script src="{{ asset('assets-dashboard/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets-dashboard/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>

    <!-- Datatable init js -->
    {{-- <script src="{{ asset('assets-dashboard/js/pages/datatables.init.js') }}"></script> --}}
@endpush
