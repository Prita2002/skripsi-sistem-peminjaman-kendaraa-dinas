@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient shadow-info border-radius-lg pt-4 pb-3" style="background: #013880">
                    <h6 class="text-white text-capitalize ps-3">User</h6>
                </div>
                <a href="{{ route('users.create') }}" class="btn btn-primary mt-3 mx-3">Tambahkan</a>
                @if (session('success'))
                    <div class="alert alert-success text-white">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="UserTable">
                        <thead>
                            <tr>
                                <th style="color: black"
                                    class="text-center text-uppercase text-xs font-weight-bolder opacity-7">
                                    No</th>
                                <th style="color: black"
                                    class="text-center text-uppercase text-xs font-weight-bolder opacity-7 ps-2">
                                    Name
                                </th>
                                <th style="color: black"
                                    class="text-center text-uppercase text-xs font-weight-bolder opacity-7 ps-2">
                                    Email
                                </th>
                                <th style="color: black"
                                    class="text-center text-uppercase text-xs font-weight-bolder opacity-7 ps-2">
                                    Role
                                </th>
                                <th style="color: black"
                                    class="text-center text-uppercase text-xs font-weight-bolder opacity-7 ps-2">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <a class="btn btn-info" onclick="showUserDetails({{ $user }})">Detail</a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- User Details Modal -->
    <div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailsModalLabel"> Detail User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="userName"></span></p>
                    <p><strong>Email:</strong> <span id="userEmail"></span></p>
                    <p><strong>Role:</strong> <span id="userRole"></span></p>
                    <p><strong>NIP:</strong> <span id="userNip"></span></p>
                    <p><strong>Username:</strong> <span id="userUsername"></span></p>
                    <p><strong>No. Telepon:</strong> <span id="userNoTelp"></span></p>
                    <p><strong>Tim Kerja:</strong> <span id="userTimKerja"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showUserDetails(user) {
            document.getElementById('userName').textContent = user.name;
            document.getElementById('userEmail').textContent = user.email;
            document.getElementById('userRole').textContent = user.role;
            document.getElementById('userNip').textContent = user.nip;
            document.getElementById('userUsername').textContent = user.username;
            document.getElementById('userNoTelp').textContent = user.no_telp;
            document.getElementById('userTimKerja').textContent = user.tim_kerja?.nama ?? 'N/A';

            var userDetailsModal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
            userDetailsModal.show();
        }
    </script>
@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#UserTable').DataTable();
        });
    </script>
@endpush
