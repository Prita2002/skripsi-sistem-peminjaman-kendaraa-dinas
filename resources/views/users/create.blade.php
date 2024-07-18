@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <div class="card p-4">
            <h2 class="mb-4">Tambahkan User</h2>

            @if (session('success'))
                <div class="alert alert-success text-white">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger text-white">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                @include('users.partials.form', ['user' => new \App\Models\User()])
                <div class="d-flex justify-content-start mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary ms-3">Kembali</a>
                    <button type="submit" class="btn btn-primary ms-3">Tambah</button>
                </div>

            </form>
        </div>
    </div>
@endsection
