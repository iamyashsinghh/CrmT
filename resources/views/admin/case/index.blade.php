@extends('admin.layouts.app')

@section('title', $page_heading)

@section('header-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('main')
    <div class="content-wrapper pb-5">
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between mb-2">
                    <h1 class="m-0">{{ $page_heading }}</h1>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="casesTable" class="table text-sm">
                        <thead class="sticky_head bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Case Code</th>
                                <th>Created By</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Corp</th>
                                <th>Relation</th>
                                <th>Gender</th>
                                <th>Date of Admission</th>
                                <th>Date of Discharge</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer-script')
    @php
    $filter = '';
    if (isset($filter_params['dashboard_filters'])) {
    $filter = 'dashboard_filters=' . $filter_params['dashboard_filters'];
    }
    @endphp
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#casesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin_case_ajax') }}`,
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id',
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'case_code',
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'created_by',
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'name',
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'age',
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'corp',
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'relation',
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'gender',
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'doa',
                        render: function(data, type, row) {
                            return moment(data.doa).format("DD-MMM-YYYY");
                        },
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'dod',
                        render: function(data, type, row) {
                            return moment(data.dod).format("DD-MMM-YYYY");
                        },
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn btn-info btn-view-case" data-id="' + row.id +
                                '">View</button>';
                        },
                        orderable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                responsive: true,
                paging: true,
                searching: true,
                lengthChange: true,
                autoWidth: false
            });
            $(document).on('click', '.btn-view-case', function() {
                var caseId = $(this).data('id');
                window.location.href = '/admin/cases/' + caseId;
            });
        });
    </script>
@endsection
