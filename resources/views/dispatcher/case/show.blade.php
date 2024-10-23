@extends('dispatcher.layouts.app')

@section('title', 'Case Details')

@section('header-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
@endsection

@section('main')
    <div class="content-wrapper pb-5 pt-4">
        <section class="content">
            <div class="card mb-3">
                <div class="card-header text-light" style="background-color: var(--wb-renosand);">
                    <h3 class="card-title">Case Information</h3>
                    <button href="javascript:void(0);" class="btn p-0 text-light float-right" title="Edit Case info."
                        data-bs-toggle="modal" data-bs-target="#editCaseModal"><i class="fa fa-edit"></i></button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Id: </span>
                            <span class="mx-1"> {{ $case->id }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Case Code: </span>
                            <span class="mx-1">{{ $case->case_code }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)"> Name: </span>
                            <span class="mx-1">{{ $case->name }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Age: </span>
                            <span class="mx-1">{{ $case->age }} </span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Gender: </span>
                            <span class="mx-1 ">{{ $case->gender }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Date of Admission: </span>
                            <span class="mx-1"> {{ date('d-M-Y', strtotime($case->doa)) }} at {{ $case->doa_time }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Date of Discharge: </span>
                            <span class="mx-1"> {{ date('d-M-Y', strtotime($case->dod)) }} at {{ $case->dod_time }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Hospital: </span>
                            <span class="mx-1">{{ $case->hospital ?? 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Diagnosis: </span>
                            <span class="mx-1">{{ $case->diagnosis ?? 'N/A' }} </span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">IPD No: </span>
                            <span class="mx-1">{{ $case->ipd_no_entry }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Status: </span>
                            <span class="mx-1">{{ $case->status }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($case->is_post_1 == 1)
                <div class="card mb-3">
                    <div class="card-header text-light" style="background-color: var(--wb-renosand);">
                        <h3 class="card-title">Post 1 Information</h3>
                        <button href="javascript:void(0);" class="btn p-0 text-light float-right"
                            title="Edit Post Case info." data-bs-toggle="modal" data-bs-target="#editCasePostModal"><i
                                class="fa fa-edit"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="text-bold mx-1" style="color: var(--wb-wood)">OPD Attachemnt: </span>
                                @if ($case->opd_attachment)
                                    <a href="{{ asset('storage/' . $case->opd_attachment) }}" target="_blank"
                                        class="text-primary">
                                        <i class="bi bi-file-earmark-text"></i> View
                                    </a>
                                @else
                                    <span class="text-muted">Not Available</span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <span class="text-bold mx-1" style="color: var(--wb-wood)">Bill Attachemnt: </span>
                                @if ($case->bill_attachment_post)
                                    <a href="{{ asset('storage/' . $case->bill_attachment_post) }}" target="_blank"
                                        class="text-primary">
                                        <i class="bi bi-file-earmark-text"></i> View
                                    </a>
                                @else
                                    <span class="text-muted">Not Available</span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <span class="text-bold mx-1" style="color: var(--wb-wood)">Status: </span>
                                <span class="mx-1">{{ $case->post_status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($case->is_post_2 == 1)
                <div class="card mb-3">
                    <div class="card-header text-light" style="background-color: var(--wb-renosand);">
                        <h3 class="card-title">Post 2 Information</h3>
                        <button href="javascript:void(0);" class="btn p-0 text-light float-right"
                            title="Edit Post Case info." data-bs-toggle="modal" data-bs-target="#editCasePostTwoModal"><i
                                class="fa fa-edit"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="text-bold mx-1" style="color: var(--wb-wood)">OPD Attachemnt: </span>
                                @if ($case->opd_attachment_2)
                                    <a href="{{ asset('storage/' . $case->opd_attachment_2) }}" target="_blank"
                                        class="text-primary">
                                        <i class="bi bi-file-earmark-text"></i> View
                                    </a>
                                @else
                                    <span class="text-muted">Not Available</span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <span class="text-bold mx-1" style="color: var(--wb-wood)">Bill Attachemnt: </span>
                                @if ($case->bill_attachment_post_two)
                                    <a href="{{ asset('storage/' . $case->bill_attachment_post_two) }}" target="_blank"
                                        class="text-primary">
                                        <i class="bi bi-file-earmark-text"></i> View
                                    </a>
                                @else
                                    <span class="text-muted">Not Available</span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <span class="text-bold mx-1" style="color: var(--wb-wood)">Status: </span>
                                <span class="mx-1">{{ $case->post_two_status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>



        <div class="modal fade" id="editCaseModal" tabindex="-1" aria-labelledby="editCaseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="editCaseForm" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCaseModalLabel">Edit Case</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <input type="hidden" name="case_id" value="{{ $case->id }}">
                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="pre_courier_no">Pre Courier No</label>
                                <input type="text" class="form-control" name="pre_courier_no" id="pre_courier_no"
                                    value="{{ $case->pre_courier_no }}">
                            </div>
                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="pre_courier_date">Pre Courier Date</label>
                                <input type="date" class="form-control" name="pre_courier_date" id="pre_courier_date"
                                    value="{{ $case->pre_courier_date }}">
                            </div>
                            <div class="form-group col-sm-12 col-lg-6">
                                <label for="pre_dispatch_pdf_attachment">Pre Dispatch Pdf</label>
                                <input type="file" class="form-control" name="pre_dispatch_pdf_attachment"
                                    id="pre_dispatch_pdf_attachment">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editCasePostModal" tabindex="-1" aria-labelledby="editCasePostModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="editCasePostModalForm" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCasePostModalLabel">Add Files</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <input type="hidden" name="case_id" value="{{ $case->id }}">
                            <div class="form-group col-sm-6">
                                <label for="post_courier_no">Post Courier No</label>
                                <input type="text" class="form-control" name="post_courier_no" id="post_courier_no"
                                    value="{{ $case->post_courier_no }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="post_courier_date">Post Courier Date</label>
                                <input type="date" class="form-control" name="post_courier_date"
                                    id="post_courier_date" value="{{ $case->post_courier_date }}">
                            </div>
                            <div class="form-group col-sm-12 col-lg-6">
                                <label for="post_dispatch_pdf_attachment">Post Dispatch Pdf</label>
                                <input type="file" class="form-control" name="post_dispatch_pdf_attachment"
                                    id="post_dispatch_pdf_attachment">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="editCasePostTwoModal" tabindex="-1" aria-labelledby="editCasePostTwoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="editCasePostTwoModalForm" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCasePostTwoModalLabel">Add Files</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <input type="hidden" name="case_id" value="{{ $case->id }}">
                            <div class="form-group col-sm-6">
                                <label for="post_two_courier_no">Post Two Courier No</label>
                                <input type="text" class="form-control" name="post_two_courier_no"
                                    id="post_two_courier_no" value="{{ $case->post_two_courier_no }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="post_two_courier_date">Post Two Courier Date</label>
                                <input type="date" class="form-control" name="post_two_courier_date"
                                    id="post_two_courier_date" value="{{ $case->post_two_courier_date }}">
                            </div>
                            <div class="form-group col-sm-12 col-lg-6">
                                <label for="post_two_dispatch_pdf_attachment">Post Two Dispatch Pdf</label>
                                <input type="file" class="form-control" name="post_two_dispatch_pdf_attachment"
                                    id="post_two_dispatch_pdf_attachment">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

@section('footer-script')
    <script>
        function openRemarkModal() {
            $('#cancelRemarkModal').modal('show');
        }
        $(document).ready(function() {
            $('#editCaseForm').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: `{{ route('dispatcher.case.update', $case->id) }}`,
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editCaseModal').modal('hide');
                            alert(response.message);
                            window.location.href = `{{ route('dispatcher.case.index') }}`;
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error: ', textStatus, errorThrown);
                        alert('An error occurred: ' + textStatus);
                    }
                });
            });
        });

        $('#editCasePostModalForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: `{{ route('dispatcher.case.update.post_one', $case->id) }}`,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#editCaseModal').modal('hide');
                        alert(response.message);
                        window.location.href = `{{ route('dispatcher.case.index') }}`;
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error: ', textStatus, errorThrown);
                    alert('An error occurred: ' + textStatus);
                }
            });
        });
        $('#editCasePostTwoModalForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: `{{ route('dispatcher.case.update.post_two', $case->id) }}`,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#editCaseModal').modal('hide');
                        alert(response.message);
                        window.location.href = `{{ route('dispatcher.case.index') }}`;
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error: ', textStatus, errorThrown);
                    alert('An error occurred: ' + textStatus);
                }
            });
        });
    </script>
@endsection

@endsection
