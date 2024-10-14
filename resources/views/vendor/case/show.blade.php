@extends('vendor.layouts.app')

@section('title', 'Case Details')

@section('header-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
@endsection

@section('main')  

<div class="content-wrapper pb-5">
  <section class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Case Details</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-sm border">
        <div class="card-body">
          <h5 class="mb-3">
            <i class="bi bi-person-circle-fill"></i>
            <strong>Name:</strong> {{ $case->name }}
          </h5>
          <h5 class="mb-3">
            <i class="bi bi-calendar-fill"></i>
            <strong>Age:</strong> {{ $case->age }}
          </h5>
          <h5 class="mb-3">
            <i class="bi bi-building-fill"></i>
            <strong>Corp:</strong> {{ $case->corp }}
          </h5>
          <h5 class="mb-3">
            <i class="bi bi-shield-check"></i>
            <strong>Case Code:</strong> {{ $case->case_code }}
          </h5>
          <h5 class="mb-3">
            <i class="bi bi-heart-fill"></i>
            <strong>Relation:</strong> {{ $case->relation }}
          </h5>
          <h5 class="mb-3">
            <i class="bi bi-gender-ambiguous"></i>
            <strong>Member Id:</strong> {{ $case->member_id }}
          </h5>
          <h5 class="mb-3">
            <i class="bi bi-gender-ambiguous"></i>
            <strong>Gender:</strong> {{ $case->gender }}
          </h5>
          <h5 class="mb-3">
            <i class="bi bi-calendar-event-fill"></i>
            <strong>Date of Admission:</strong> {{ $case->doa }} at {{ $case->doa_time }}
          </h5>
          <h5 class="mb-3">
            <i class="bi bi-calendar-x-fill"></i>
            <strong>Date of Discharge:</strong> {{ $case->dod }} at {{ $case->dod_time }}
          </h5>

          <h5 class="mb-3">
            <strong>Aadhar Attachment:</strong>
            @if($case->aadhar_attachment)
              <a href="{{ asset('storage/' . $case->aadhar_attachment) }}" target="_blank" class="text-primary">
                <i class="bi bi-file-earmark-text"></i> View
              </a>
            @else
              <span class="text-muted">Not Available</span>
            @endif
          </h5>
          <h5 class="mb-3">
            <strong>PAN Card:</strong>
            @if($case->pan_card)
              <a href="{{ asset('storage/' . $case->pan_card) }}" target="_blank" class="text-primary">
                <i class="bi bi-file-earmark-text"></i> View
              </a>
            @else
              <span class="text-muted">Not Available</span>
            @endif
          </h5>
          <h5 class="mb-3">
            <strong>Cancelled Cheque:</strong>
            @if($case->cancelled_cheque)
              <a href="{{ asset('storage/' . $case->cancelled_cheque) }}" target="_blank" class="text-primary">
                <i class="bi bi-file-earmark-text"></i> View
              </a>
            @else
              <span class="text-muted">Not Available</span>
            @endif
          </h5>
          <h5 class="mb-3">
            <strong>Policy:</strong>
            @if($case->policy)
              <a href="{{ asset('storage/' . $case->policy) }}" target="_blank" class="text-primary">
                <i class="bi bi-file-earmark-text"></i> View
              </a>
            @else
              <span class="text-muted">Not Available</span>
            @endif
          </h5>

          {{-- <button class="btn btn-primary mt-3 px-4" data-bs-toggle="modal" data-bs-target="#editCaseModal">
            <i class="bi bi-pencil-fill"></i> Edit Case
          </button> --}}
        </div>
      </div>
    </div>
  </section>

    <!-- Modal for editing the case -->
    <div class="modal fade" id="editCaseModal" tabindex="-1" aria-labelledby="editCaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editCaseForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCaseModalLabel">Edit Case</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="case_id" value="{{ $case->id }}">
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $case->name }}" required>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" name="age" id="age" value="{{ $case->age }}" required>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="corp">Corp</label>
                            <input type="text" class="form-control" name="corp" id="corp" value="{{ $case->corp }}" required>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="member_id">Member Id</label>
                            <input type="text" class="form-control" name="member_id" id="member_id" value="{{ $case->member_id }}" required>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="relation">Relation</label>
                            <select class="form-control" name="relation" id="relation" required>
                                <option value="self" {{ $case->relation == 'self' ? 'selected' : '' }}>Self</option>
                                <option value="mother" {{ $case->relation == 'mother' ? 'selected' : '' }}>Mother</option>
                                <option value="father" {{ $case->relation == 'father' ? 'selected' : '' }}>Father</option>
                                <option value="daughter" {{ $case->relation == 'daughter' ? 'selected' : '' }}>Daughter</option>
                                <option value="son" {{ $case->relation == 'son' ? 'selected' : '' }}>Son</option>
                                <option value="husband" {{ $case->relation == 'husband' ? 'selected' : '' }}>Husband</option>
                                <option value="wife" {{ $case->relation == 'wife' ? 'selected' : '' }}>Wife</option>
                                <option value="brother" {{ $case->relation == 'brother' ? 'selected' : '' }}>Brother</option>
                                <option value="sister" {{ $case->relation == 'sister' ? 'selected' : '' }}>Sister</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender" id="gender" required>
                                <option value="Male" {{ $case->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $case->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $case->gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="doa">Date of Admission</label>
                            <input type="date" class="form-control" name="doa" id="doa" value="{{ $case->doa }}" required>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="doa_time">Time of Admission</label>
                            <input type="time" class="form-control" name="doa_time" id="doa_time" value="{{ $case->doa_time }}" required>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="dod">Date of Discharge</label>
                            <input type="date" class="form-control" name="dod" id="dod" value="{{ $case->dod }}" required>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="dod_time">Time of Discharge</label>
                            <input type="time" class="form-control" name="dod_time" id="dod_time" value="{{ $case->dod_time }}" required>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="aadhar_attachment">Aadhar Attachment</label>
                            <input type="file" class="form-control" name="aadhar_attachment" id="aadhar_attachment">
                            <small class="text-muted">Leave blank if you don't want to change</small>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="pan_card">PAN Card</label>
                            <input type="file" class="form-control" name="pan_card" id="pan_card">
                            <small class="text-muted">Leave blank if you don't want to change</small>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="cancelled_cheque">Cancelled Cheque</label>
                            <input type="file" class="form-control" name="cancelled_cheque" id="cancelled_cheque">
                            <small class="text-muted">Leave blank if you don't want to change</small>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="policy">Policy</label>
                            <input type="file" class="form-control" name="policy" id="policy">
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
</div>

@section('footer-script')
    <script>
        $(document).ready(function() {
            $('#editCaseForm').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: `{{ route('vendor.case.update', $case->id) }}`,
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
