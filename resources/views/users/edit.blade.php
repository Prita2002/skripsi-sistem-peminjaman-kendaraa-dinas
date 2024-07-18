@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Edit User</h2>
        @if (session('success'))
            <div class="alert alert-success text-white">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')
            @include('users.partials.form', ['user' => $user])
            <a href="{{ route('users.index') }}" class="btn btn-secondary ms-3">Kembali</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
