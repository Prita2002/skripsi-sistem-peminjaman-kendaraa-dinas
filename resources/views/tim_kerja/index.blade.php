@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="card my-4">
            <div class="bg-gradient shadow-info border-radius-lg pt-4 pb-3" style="background: #013880">
                <h6 class="text-white text-capitalize ps-3">Tim Kerja Management</h6>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-3 mx-3 text-white">
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger mt-3 mx-3 text-white">
                    {{ $message }}
                </div>
            @endif
            <div class="card-body  px-0 pb-2">
                <a class="btn btn-primary mt-3 mx-3" data-bs-toggle="modal" data-bs-target="#createTimKerjaModal">
                    Tambahkan Tim Kerja
                </a>
            </div>

            <div class="card p-3 wrap-text">
                <div class="table-responsive px-3">
                    <table class="table align-items-center mb-0 text-dark" id="TimkerjaTable">
                        <thead>
                            <tr>
                                <th width="50px" style="color: black;"
                                    class="text-center text-uppercase text-xs font-weight-bolder opacity-7">No</th>
                                <th width="300px" style="color: black;"
                                    class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Nama</th>
                                <th width="280px" style="color: black;"
                                    class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Action</th>
                            </tr>
                        </thead>

                        @foreach ($timKerja as $tim)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tim->nama }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editTimKerjaModal{{ $tim->id }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('tim_kerja.destroy', $tim->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>

        </div>

    </div>

    <!-- Create Tim Kerja Modal -->
    <div class="modal fade" id="createTimKerjaModal" tabindex="-1" aria-labelledby="createTimKerjaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tim_kerja.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTimKerjaModalLabel">Create Tim Kerja</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 input-group input-group-static mb-4">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tim Kerja Modal -->
    @foreach ($timKerja as $tim)
        <div class="modal fade" id="editTimKerjaModal{{ $tim->id }}" tabindex="-1"
            aria-labelledby="editTimKerjaModalLabel{{ $tim->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('tim_kerja.update', $tim->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTimKerjaModalLabel{{ $tim->id }}">Edit Tim Kerja</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ $tim->nama }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#TimkerjaTable').DataTable();
        });
    </script>
@endpush
