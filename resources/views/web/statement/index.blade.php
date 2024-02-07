@extends('layouts.contentNavbarLayout')

@section('title', 'Statement | Banking-App')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet"
          href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-select-bs5/select.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="px-3 card-header border-bottom d-flex align-items-center flex-column flex-md-row">
                <div class="head-label">
                    <h5 class="card-title mb-0">Statement of account</h5>
                </div>
            </div>
            <div class="card-datatable dataTable_select table-responsive">
                <table class="table border-top dataTable"
                       id="DataTables" aria-describedby="DataTables_info" style="width:100%;">
                </table>
            </div>

        </div>
    </div>
@endsection

@section('page-script')
    <script>
        let table;
        $(document).ready(function () {

            table = $('#DataTables').DataTable({
                processing: true,
                autoWidth: true,
                serverSide: false,
                ordering: false,
                select: {
                    style: 'multi',
                    selector: 'td:first-child',
                },
                searching: true,
                columnDefs: [{
                    targets: 0,
                    searchable: false,
                    render: function (data, type, row) {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input"  data-id="' + row.id + '">'
                    },
                    checkboxes: {selectRow: !0, selectAllRender: '<input type="checkbox" class="form-check-input">'}
                }, {
                    orderable: false,
                }],
                lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
                iDisplayLength: 10,
                ajax: {
                    url: "{{ route('statement') }}",
                },
                columns: [
                    {
                        title: 'id',
                        data: 'id',
                    }, {
                        title: '#',
                        data: null,
                    },
                    {
                        title: 'DateTime',
                        data: 'datetime',
                    }, {
                        title: 'Amount',
                        data: 'amount',
                    }, {
                        title: 'Type',
                        data: 'type',
                    }, {
                        title: 'Details',
                        data: 'description',
                    }, {
                        title: 'Balance',
                        data: 'balance',
                    }
                ]
            });

            $('#DataTables_length').append('<button id="deleteButton" class="ms-2 btn btn-danger btn-sm" style="display: none"><i class="me-2 font-size-1 bx bxs-trash"></i>Delete Selected</button>');

            // Add row numbers to the first column also when filter or order changed
            table.on('order.dt search.dt', function () {
                table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            // Event listener for the DataTable select event
            table.on('select deselect', function () {
                // Check if any row is selected
                let anyRowSelected = table.rows({selected: true}).count() > 0;
                if (anyRowSelected) {
                    $('#deleteButton').show();
                } else {
                    $('#deleteButton').hide();
                }
            });

            $('#deleteButton').on('click', function () {
                let selectedIds = table.rows({selected: true}).data().pluck('id').toArray();
                if (selectedIds.length > 0) {
                    selectedIds = selectedIds.join(',');
                    deleteRecord(selectedIds);
                }
            });
        });

        function deleteRecord(selectedIds) {
            console.log(selectedIds);
        }
    </script>

@endsection

