<!-- resources/views/profile/show.blade.php -->

@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Profile</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($user)
            <div class="card">
                <div class="card-header">
                    Profile Information
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm float-end">Edit Profile</a>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>NIP:</strong> {{ $user->nip }}</p>
                    <p><strong>Username:</strong> {{ $user->username }}</p>
                    <p><strong>Role:</strong> {{ $user->role }}</p>
                    <p><strong>No Telp:</strong> {{ $user->no_telp }}</p>
                    <p><strong>Tim Kerja:</strong> {{ $user->timKerja ? $user->timKerja->nama : '-' }}</p>
                </div>
            </div>
        @else
            <div class="alert alert-danger">
                User not found or not authenticated.
            </div>
        @endif
    </div>
@endsection
