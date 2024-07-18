<!-- resources/views/users/show.blade.php -->
@extends('layouts.layout')

@section('content')
    <div class="container">
        @include('users.partials.user-detail', ['user' => $user])
    </div>
@endsection
