@props(['needrange' => null, 'url' => '', 'titlepage' => ''])
@section('custom-footer')
    <script>
        // mengambil URL saat ini
        $(document).ready(() => {
            var table = $('.datatables-target-exec').DataTable({
                ...{
                    ajax: {
                        url: "{{ $url }}",
                        data: function(d) {
                            d.start_date = searchParams.get('start_date') ?? null
                            d.end_date = searchParams.get('end_date') ?? null
                        }
                    },
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
                ...optionDatatables,
                ...{
                    responsive: true,
                }
            });
        })
    </script>
@endsection

@push('additional-header')
    <!-- DataTables -->
    <link href="{{ asset('assets-dashboard/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets-dashboard/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets-dashboard/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endpush

@push('additional-footer')
    <!-- Required datatable js -->
    <script src="{{ asset('assets-dashboard/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/buttons.dataTables.js') }}"></script>
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

@if (isset($needrange))
    @push('additional-footer')
        <script>
            // mengambil URL saat ini
            let currentUrl = window.location.search;

            // membuat objek URLSearchParams dari URL saat ini
            var searchParams = new URLSearchParams(currentUrl);
            $(document).ready(() => {

                $(function() {
                    $('input[name="daterange"]').daterangepicker({
                            opens: 'left', // position of calendar popup
                            startDate: searchParams.get('start_date') ?? moment().startOf(
                                'month'), // initial start date
                            endDate: searchParams.get('end_date') ?? moment().endOf(
                                'month'), // initial end date
                            locale: {
                                format: 'YYYY-MM-DD' // date format
                            }
                        },
                        function(start, end, label) {
                            // menambahkan query string baru pada objek URLSearchParams
                            searchParams.set('start_date', start.format('YYYY-MM-DD'));
                            searchParams.set('end_date', end.format('YYYY-MM-DD'));

                            // melakukan redirect ke URL yang baru
                            window.location.search = searchParams.toString();
                        });
                });
            })
        </script>
        <script>
            optionDatatables = {
                dom: 'lBftrip',
                buttons: [
                    {
                        extend: 'colvis',
                        className: 'btn bg-red-500 border-red-500 hover:bg-red-600 hover:border-red-600 focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-500/30 active:bg-red-600 active:border-red-600',
                        text: '<i class="fa fa-eye"></i> Visibility Column',
                    },{
                        extend: 'excel',
                        className: 'btn bg-red-500 border-red-500 hover:bg-red-600 hover:border-red-600 focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-500/30 active:bg-red-600 active:border-red-600',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },

                    {
                        extend: 'pdf',
                        className: 'btn bg-red-500 border-red-500 hover:bg-red-600 hover:border-red-600 focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-500/30 active:bg-red-600 active:border-red-600 buttons-pdf',
                        text: '<i class="fa fa-file-pdf"></i> PDF',
                        customize: function(doc) {
                            // Set the page margins
                            doc.pageMargins = [40, 60, 40, 60];

                            // Set the default font size
                            doc.defaultStyle.fontSize = 10;

                            // mengambil URL saat ini
                            let currentUrl = window.location.search;

                            // membuat objek URLSearchParams dari URL saat ini
                            var searchParams = new URLSearchParams(currentUrl);

                            var dateSubTitle = '';
                            var systemFormatDate = "YYYY-MM-DD";
                            var humanFormatDate = "DD MMMM YYYY";

                            // Set judul dokumen PDF
                            var rawTitlePage = document.title.split("|")
                            var startDate = searchParams.get('start_date');
                            var endDate = searchParams.get('end_date');
                            if (startDate && endDate) {
                                dateSubTitle = 'Periode: ' + moment(startDate, systemFormatDate).format(
                                        humanFormatDate) +
                                    ' - ' + moment(endDate, systemFormatDate).format(humanFormatDate)
                            } else {
                                dateSubTitle = 'Periode: ' + moment().startOf('month').format(humanFormatDate) +
                                    ' - ' +
                                    moment().endOf('month').format(humanFormatDate)
                            }

                            doc.content[0].text = '{{ $titlepage }}'
                            doc.content.splice(1, 0, {
                                text: dateSubTitle,
                                alignment: 'center',
                                margin: [0, 0, 0, 15]
                            });

                            // Set the table layout to center
                            doc.content[2].layout = {
                                hLineWidth: function(i, node) {
                                    return 0.5;
                                },
                                vLineWidth: function(i, node) {
                                    return 0.5;
                                },
                                hLineColor: function(i, node) {
                                    return '#aaa';
                                },
                                vLineColor: function(i, node) {
                                    return '#aaa';
                                },
                                fillColor: function(i, node) {
                                    return (i % 2 === 0) ? '#eee' : '#fff';
                                },
                                paddingLeft: function(i, node) {
                                    return 10;
                                },
                                paddingRight: function(i, node) {
                                    return 10;
                                },
                                paddingTop: function(i, node) {
                                    return 5;
                                },
                                paddingBottom: function(i, node) {
                                    return 5;
                                },
                                fillColor: '#fff',
                                alignment: 'center'
                            }

                        }
                    },
                    // {
                    //     extend: 'print',
                    //     className: 'btn btn-outline-primary'
                    // }
                ],
                pagingType: 'full_numbers',
                // pageLength: 10, //pagelength,
                lengthMenu: [
                    [10, 25, 50, 100, 250, -1],
                    [10, 25, 50, 100, 250, "All"]
                ],
                processing: true,
                serverSide: true,
                searching: true,
            }
        </script>
    @endpush
@else
    @push('additional-footer')
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
        </script>
    @endpush
@endif
