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
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCaseModal">Create New
                        Case</button>
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
        <div class="modal fade" id="createCaseModal" tabindex="-1" aria-labelledby="createCaseModalLabel">
            <div class="modal-dialog modal-lg">
                <form id="createCaseForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCaseModalLabel">Create Case</h5>
                            <a class="btn btn-close txt-black" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <div class="modal-body row">
                            <div class="form-group col-lg-6 col-sm-12">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label>Age</label>
                                <input type="number" class="form-control" name="age" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label>Corp</label>
                                <input type="text" class="form-control" name="corp" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="member_id">Member Id</label>
                                <input type="text" class="form-control" name="member_id" id="member_id" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="relation">Relation</label>
                                <select class="form-control" name="relation" id="relation" required>
                                    <option value="self">Self</option>
                                    <option value="mother">Mother</option>
                                    <option value="father">Father</option>
                                    <option value="daughter">Daughter</option>
                                    <option value="son">Son</option>
                                    <option value="husband">Husband</option>
                                    <option value="wife">Wife</option>
                                    <option value="brother">Brother</option>
                                    <option value="sister">Sister</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label>Gender</label>
                                <select class="form-control" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label>Date of Admission</label>
                                <input type="date" class="form-control" name="doa" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label>Time of Admission</label>
                                <input type="time" class="form-control" name="doa_time" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label>Date of Discharge</label>
                                <input type="date" class="form-control" name="dod" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label>Time of Discharge</label>
                                <input type="time" class="form-control" name="dod_time" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="aadhar_attachment">Aadhar Attachment</label>
                                <input type="file" class="form-control" name="aadhar_attachment" id="aadhar_attachment">
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="pan_card">PAN Card</label>
                                <input type="file" class="form-control" name="pan_card" id="pan_card">
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="cancelled_cheque">Cancelled Cheque</label>
                                <input type="file" class="form-control" name="cancelled_cheque" id="cancelled_cheque">
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="policy">Policy</label>
                                <input type="file" class="form-control" name="policy" id="policy">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create Case</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
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
                        searchable: true,
                        sortable: true
                    },
                    {
                        data: 'dod',
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


            $('#createCaseForm').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: `{{ route('admin.case.store') }}`,
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#createCaseModal').modal('hide');
                            table.ajax.reload();
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
@endsection
