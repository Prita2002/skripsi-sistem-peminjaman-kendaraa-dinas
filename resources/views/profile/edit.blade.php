<!-- resources/views/profile/edit.blade.php -->

@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Edit Profile</h1>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    Edit Profile Information
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control border border-dark p-2" id="name" name="name"
                            value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control border border-dark p-2" id="email" name="email"
                            value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control border border-dark p-2" id="password" name="password"
                            placeholder="Leave blank to keep current password">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control border border-dark p-2" id="password_confirmation"
                            name="password_confirmation" placeholder="Leave blank to keep current password">
                    </div>
                    <div class="form-group mb-3">
                        <label for="nip">NIP</label>
                        <input type="text" class="form-control border border-dark p-2" id="nip" name="nip"
                            value="{{ $user->nip }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control border border-dark p-2" id="username" name="username"
                            value="{{ $user->username }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="role">Role</label>
                        <input type="text" class="form-control border border-dark p-2" id="role" name="role"
                            value="{{ $user->role }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="no_telp">No Telp</label>
                        <input type="text" class="form-control border border-dark p-2" id="no_telp" name="no_telp"
                            value="{{ $user->no_telp }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="tim_kerja_id">Tim Kerja</label>
                        <select class="form-control border border-dark p-2" id="tim_kerja_id" name="tim_kerja_id">
                            @foreach ($timKerjas as $timKerja)
                                <option value="{{ $timKerja->id }}"
                                    {{ $user->tim_kerja_id == $timKerja->id ? 'selected' : '' }}>
                                    {{ $timKerja->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('profile') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
@endsection
