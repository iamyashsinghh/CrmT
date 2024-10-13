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
                        <form action="{{ isset($user->id) ? route('admin.users.manage_process', $user->id) : route('admin.users.manage_process') }}" method="POST">
                            @csrf
                            <!-- First Name -->
                            <div class="form-group">
                                <label for="f_name">First Name</label>
                                <input type="text" class="form-control @error('f_name') is-invalid @enderror" id="f_name" name="f_name" value="{{ old('f_name', $user->f_name ?? '') }}" required>
                                @error('f_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <label for="l_name">Last Name</label>
                                <input type="text" class="form-control @error('l_name') is-invalid @enderror" id="l_name" name="l_name" value="{{ old('l_name', $user->l_name ?? '') }}" required>
                                @error('l_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Leave blank to keep current password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control @error('role_id') is-invalid @enderror" id="role" name="role_id" required>
                                    <option value="" >Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ (old('role_id', $user->role_id ?? '') == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">{{ isset($user->id) ? 'Update User' : 'Create User' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
