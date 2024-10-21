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
                    <table id="walletsTable" class="table text-sm">
                        <thead class="sticky_head bg-light">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Paid By</th>
                                <th>Amount</th>
                                <th>Payment Type</th>
                                <th>Payment Proof</th>
                                <th>Message</th>
                                <th>Status</th>
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
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#walletsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.vendor.wallets.ajax') }}`,
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user.f_name',
                        name: 'user.f_name'
                    },
                    {
                        data: 'paid_by_name',
                        name: 'paid_by_name'
                    },
                    {
                        data: 'ammount',
                        name: 'amount'
                    },
                    {
                        data: 'payment_type',
                        name: 'payment_type'
                    },
                    {
                        data: 'payment_proof',
                        name: 'payment_proof',
                        render: function(data) {
                            return `<a href="/storage/${data}" target="_blank">View Proof</a>`;
                        }
                    },
                    {
                        data: 'msg',
                        name: 'msg'
                    },
                    {
                        data: 'is_approved',
                        name: 'is_approved',
                        render: function(data, type, row) {
                            let statusText = '';
                            let buttonClass = '';

                            if (data == 0) {
                                statusText = 'Pending';
                                buttonClass = 'btn-warning';
                            } else if (data == 1) {
                                statusText = 'Approved';
                                buttonClass = 'btn-success';
                            } else if (data == 2) {
                                statusText = 'Cancelled';
                                buttonClass = 'btn-danger';
                            }

                            return `
                            <div class="dropdown">
                                <button class="btn ${buttonClass} dropdown-toggle btn-xs p-2 m-1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Status: ${statusText}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="updateStatus(${row.id}, 0)">Pending</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="updateStatus(${row.id}, 1)">Approved</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="updateStatus(${row.id}, 2)">Cancelled</a></li>
                                </ul>
                            </div>`;
                        }
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

            window.updateStatus = function(id, status) {
            $.ajax({
                url: `{{ route('admin.vendor.wallets.updateStatus') }}`,
                method: 'POST',
                data: {
                    _token: `{{ csrf_token() }}`,
                    id: id,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        table.ajax.reload();
                        alert(response.message);
                    } else {
                        alert('Error updating status');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
        });
    </script>
@endsection
