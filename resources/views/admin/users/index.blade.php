@extends('admin.layouts.app')

@section('title', $page_heading . ' | Users')

@section('header-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('main')
    <div class="content-wrapper pb-5">
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between mb-2">
                    <h1 class="m-0">{{ $page_heading }}</h1>
                    <a href="{{ route('admin.users.manage') }}" class="btn btn-primary">Add New User</a>
                </div>

                <div class="btn-group mb-3">
                    <button class="btn btn-secondary role-filter active" data-role="">All</button>
                    @foreach ($roles as $role)
                        <button class="btn btn-secondary role-filter"
                            data-role="{{ $role->name }}">{{ $role->name }}</button>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="serverTable" class="table text-sm">
                        <thead class="sticky_head bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer-script')
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script>
        $(function() {
            var table = $('#serverTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.users.getUsers') }}",
                    data: function(d) {
                        d.role = $('.role-filter.active').data('role') || '';
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'profile_image',
                        name: 'profile_image',
                        render: function(data, type, row) {
                            var imageUrl = data ? `/storage/${data}` :
                                '{{ asset('images/default-user.png') }}';
                            return `<a onclick="handle_view_image('${imageUrl}', '{{ route('updateProfileImage') }}/${row.id}')" href="javascript:void(0);">
                    <img class="img-thumbnail" src="${imageUrl}" style="width: 50px;" onerror="this.onerror=null; this.src='{{ asset('images/default-user.png') }}'">
                </a>`;
                        }
                    },
                    {
                        data: 'f_name',
                        name: 'f_name'
                    },
                    {
                        data: 'l_name',
                        name: 'l_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'get_role.name',
                        name: 'role'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            return moment(data).format('DD MMMM YYYY');
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            const csrfToken = "{{ csrf_token() }}";

            $(document).on('click', '.delete-btn', function() {
                if (confirm('Are you sure you want to delete this user?')) {
                    var userId = $(this).data('id');
                    $.ajax({
                        url: "{{ route('admin.users.destroy', '') }}/" + userId,
                        type: 'get',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            alert(response.message);
                            table.ajax.reload();
                        }
                    });
                }
            });

            $('.role-filter').on('click', function() {
                $('.role-filter').removeClass('active');
                $(this).addClass('active');
                table.ajax.reload();
            });
        });
    </script>
@endsection
