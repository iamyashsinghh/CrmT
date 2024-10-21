@extends('admin.layouts.app')

@section('title', isset($user->id) ? 'Edit User' : 'Add User')

@section('header-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('main')
    <div class="content-wrapper pb-5">
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between mb-2">
                    <h1 class="m-0">{{ isset($user->id) ? 'Edit User' : 'Add User' }}</h1>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ isset($user->id) ? route('admin.users.manage_process', $user->id) : route('admin.users.manage_process') }}"
                            method="POST">
                            @csrf
                            <div class="row"><!-- First Name -->
                                <div class="form-group col-6">
                                    <label for="f_name">First Name</label>
                                    <input type="text" class="form-control @error('f_name') is-invalid @enderror"
                                        id="f_name" name="f_name" value="{{ old('f_name', $user->f_name ?? '') }}"
                                        required>
                                    @error('f_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="form-group col-6">
                                    <label for="l_name">Last Name</label>
                                    <input type="text" class="form-control @error('l_name') is-invalid @enderror"
                                        id="l_name" name="l_name" value="{{ old('l_name', $user->l_name ?? '') }}"
                                        required>
                                    @error('l_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group col-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group col-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Leave blank to keep current password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Role -->
                                <div class="form-group col-12">
                                    <label for="role">Role</label>
                                    <select class="form-control @error('role_id') is-invalid @enderror" id="role"
                                        name="role_id" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div id="commissionFieldsContainer" class="row" style="display: none;">
                                <!-- Commission % for Role ID 10 or 8 -->
                                <div id="commissionMainContainer" class="form-group col-6" style="display: none;">
                                    <label for="commission_main">Direct Commission %</label>
                                    <input type="number"
                                        class="form-control @error('commission_main') is-invalid @enderror"
                                        id="commission_main" name="commission_main"
                                        value="{{ old('commission_main', $user->commission_main ?? '') }}">
                                    @error('commission_main')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- First Commission % for Role ID 8 -->
                                <div id="commissionFirstContainer" class="form-group col-6" style="display: none;">
                                    <label for="commission_first">First Commission %</label>
                                    <input type="number"
                                        class="form-control @error('commission_first') is-invalid @enderror"
                                        id="commission_first" name="commission_first"
                                        value="{{ old('commission_first', $user->commission_first ?? '') }}">
                                    @error('commission_first')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Second Commission % for Role ID 8 -->
                                <div id="commissionSecondContainer" class="form-group col-6" style="display: none;">
                                    <label for="commission_second">Second Commission %</label>
                                    <input type="number"
                                        class="form-control @error('commission_second') is-invalid @enderror"
                                        id="commission_second" name="commission_second"
                                        value="{{ old('commission_second', $user->commission_second ?? '') }}">
                                    @error('commission_second')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="vendorWalletPassContainer" class="form-group col-6" style="display: none;">
                                    <label for="v_password">Vendor Wallet Password</label>
                                    <input type="text"
                                        class="form-control @error('v_password') is-invalid @enderror"
                                        id="v_password" name="v_password"
                                        value="">
                                    @error('v_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <!-- Submit Button -->
                            <button type="submit"
                                class="btn btn-primary">{{ isset($user->id) ? 'Update User' : 'Create User' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@section('footer-script')
    <script>
        $(document).ready(function() {
            function toggleCommissionFields(roleId) {
                $('#commissionFieldsContainer').hide();
                $('#commissionMainContainer').hide();
                $('#commissionFirstContainer').hide();
                $('#commissionSecondContainer').hide();
                $('#vendorWalletPassContainer').hide();

                if (roleId == 10) {
                    $('#commissionFieldsContainer').show();
                    $('#commissionMainContainer').show();
                    $('#vendorWalletPassContainer').show();
                } else if (roleId == 8) {
                    $('#commissionFieldsContainer').show();
                    $('#commissionMainContainer').show();
                    $('#commissionFirstContainer').show();
                    $('#commissionSecondContainer').show();
                }
            }

            const initialRoleId = $('#role').val();
            toggleCommissionFields(initialRoleId);

            $('#role').change(function() {
                toggleCommissionFields($(this).val());
            });
        });
    </script>

@endsection
@endsection
