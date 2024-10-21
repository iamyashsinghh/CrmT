@extends('postsales.layouts.app')

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
                            <span class="mx-1">{{ $case->diagnosis ?? 'N/A'}} </span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">IPD No: </span>
                            <span class="mx-1">{{ $case->ipd_no_entry }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Status: </span>
                            <span class="mx-1 badge">{{ $case->status }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Patient Dtetails: </span>
                            @if ($case->patient_details_form)
                                <a href="{{ asset('storage/' . $case->patient_details_form) }}" target="_blank"
                                    class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header text-light" style="background-color: var(--wb-renosand);">
                    <h3 class="card-title">Case Information Files</h3>
                    <button href="javascript:void(0);" class="btn p-0 text-light float-right" title="Edit Case files."
                    data-bs-toggle="modal" data-bs-target="#editCaseFileModal"><i class="fa fa-edit"></i></button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">ICP Attachment: </span>
                            @if ($case->icp_attachment)
                                <a href="{{ asset('storage/' . $case->icp_attachment) }}" target="_blank"
                                    class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Medicine Vitals: </span>
                            @if ($case->medicine_vitals_attached)
                                <a href="{{ asset('storage/' . $case->medicine_vitals_attached) }}" target="_blank"
                                    class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Medicine Detail: </span>
                            @if ($case->medicine_detail)
                                <a href="{{ asset('storage/' . $case->medicine_detail) }}" target="_blank" class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Aadhar Attachment: </span>
                            @if ($case->aadhar_attachment)
                                <a href="{{ asset('storage/' . $case->aadhar_attachment) }}" target="_blank"
                                    class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Aadhar Attachment 2: </span>
                            @if ($case->aadhar_attachment_2)
                                <a href="{{ asset('storage/' . $case->aadhar_attachment_2) }}" target="_blank"
                                    class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">PAN Card: </span>
                            @if ($case->pan_card)
                                <a href="{{ asset('storage/' . $case->pan_card) }}" target="_blank"
                                    class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Cancelled Cheque: </span>
                            @if ($case->cancelled_cheque)
                                <a href="{{ asset('storage/' . $case->cancelled_cheque) }}" target="_blank"
                                    class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Policy: </span>
                            @if ($case->policy)
                                <a href="{{ asset('storage/' . $case->policy) }}" target="_blank" class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Bill Attachment: </span>
                            @if ($case->bill_attachment_1)
                                <a href="{{ asset('storage/' . $case->bill_attachment_1) }}" target="_blank" class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <span class="text-bold mx-1" style="color: var(--wb-wood)">Discharge Summary: </span>
                            @if ($case->discharge_summary_attachment)
                                <a href="{{ asset('storage/' . $case->discharge_summary_attachment) }}" target="_blank" class="text-primary">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </a>
                            @else
                                <span class="text-muted">Not Available</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-5">
                <div class="card-header text-light" style="background-color: var(--wb-renosand);">
                    <h3 class="card-title">Queries</h3>
                    <button href="javascript:void(0);" class="btn p-0 text-light float-right" title="Add Query."
                    data-bs-toggle="modal" data-bs-target="#addQueryModal"><i class="fa fa-plus"></i></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="serverTable" class="table mb-0" style="background-color: #e0eb3f5c">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">S.No.</th>
                                    <th class="text-nowrap">Created At</th>
                                    <th class="">Query</th>
                                    <th class="text-nowrap">Query PDF</th>
                                </tr>
                            </thead>

                            <body>
                                @if (sizeof($case->get_guery) > 0)
                                    @foreach ($case->get_guery as $key => $query)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ date('d-M-Y h:i a', strtotime($query->created_at)) }}</td>
                                            <td>
                                                <button class="btn"
                                                    onclick="handle_view_message(`{{ $query->query ?: 'N/A' }}`)"><i
                                                        class="fa fa-comment-dots"
                                                        style="color: var(--wb-renosand);"></i></button>
                                            </td>
                                            <td> @if ($query->query_pdf)
                                                <a href="{{ asset('storage/' . $query->query_pdf) }}" target="_blank"
                                                    class="text-primary">
                                                    <i class="bi bi-file-earmark-text"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted">Not Available</span>
                                            @endif</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center text-muted" colspan="5">No data available in
                                            table</td>
                                    </tr>
                                @endif
                            </body>
                        </table>
                    </div>
                </div>
            </div>
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
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="Query" {{ $case->status == 'Query' ? 'selected' : '' }}>Query</option>
                                    <option value="Investigation" {{ $case->status == 'Investigation' ? 'selected' : '' }}>Investigation
                                    </option>
                                    <option value="Reject" {{ $case->status == 'Reject' ? 'selected' : '' }}>Reject</option>
                                    <option value="UnderProocess" {{ $case->status == 'UnderProocess' ? 'selected' : '' }}>UnderProocess</option>
                                    <option value="Approved" {{ $case->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Paid" {{ $case->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="approved_amt">Approved Amount</label>
                                <input type="text" class="form-control" name="approved_amt" id="approved_amt"
                                    value="{{ $case->approved_amt }}">
                            </div>
                            <div class="form-group col-lg-6 col-sm-6">
                                <label for="claim_no">Claim No</label>
                                <input type="text" class="form-control" name="claim_no" id="claim_no"
                                    value="{{ $case->claim_no }}">
                            </div>
                            <div class="form-group col-sm-12 col-lg-6">
                                <label for="patient_details_form">Patient Dtetails</label>
                                <input type="file" class="form-control" name="patient_details_form" id="patient_details_form">
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
        <div class="modal fade" id="editCaseFileModal" tabindex="-1" aria-labelledby="editCaseFileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="editCaseFileForm" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCaseFileModalLabel">Edit Case Files</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <input type="hidden" name="case_id" value="{{ $case->id }}">
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="aadhar_attachment">Aadhar Attachment</label>
                                <input type="file" class="form-control" name="aadhar_attachment"
                                    id="aadhar_attachment">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="aadhar_attachment_2">Aadhar Attachment 2</label>
                                <input type="file" class="form-control" name="aadhar_attachment_2"
                                    id="aadhar_attachment_2">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="pan_card">PAN Card</label>
                                <input type="file" class="form-control" name="pan_card" id="pan_card">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="cancelled_cheque">Cancelled Cheque</label>
                                <input type="file" class="form-control" name="cancelled_cheque"
                                    id="cancelled_cheque">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="policy">Policy</label>
                                <input type="file" class="form-control" name="policy" id="policy">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>

                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="icp_attachment">ICP Attachment</label>
                                <input type="file" class="form-control" name="icp_attachment"
                                    id="icp_attachment">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="patient_details_form">Patient Details Form</label>
                                <input type="file" class="form-control" name="patient_details_form"
                                    id="patient_details_form">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="medicine_vitals_attached">Medicine Vitals</label>
                                <input type="file" class="form-control" name="medicine_vitals_attached" id="medicine_vitals_attached">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="medicine_detail">Medicine Detail</label>
                                <input type="file" class="form-control" name="medicine_detail"
                                    id="medicine_detail">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="bill_attachment_1">Bill Attachment</label>
                                <input type="file" class="form-control" name="bill_attachment_1" id="bill_attachment_1">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="discharge_summary_attachment">Discharge Summary</label>
                                <input type="file" class="form-control" name="discharge_summary_attachment" id="discharge_summary_attachment">
                                <small class="text-muted">Leave blank if you don't want to change</small>
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
        <div class="modal fade" id="addQueryModal" tabindex="-1" aria-labelledby="addQueryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="addQueryForm" action="{{route('postsales.query.add')}}" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addQueryModalLabel">Edit Case</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <input type="hidden" name="case_id" value="{{ $case->id }}">
                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="query">Query</label>
                                <textarea name="query" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-sm-12 col-lg-12">
                                <label for="query_pdf">Query PDF</label>
                                <input type="file" class="form-control" name="query_pdf" id="query_pdf">
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
                    url: `{{ route('postsales.case.update', $case->id) }}`,
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
                            location.reload();
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

        $(document).ready(function() {
            $('#editCaseFileForm').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: `{{ route('postsales.case.files.update', $case->id) }}`,
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
                            location.reload();
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
    </script>
@endsection

@endsection
