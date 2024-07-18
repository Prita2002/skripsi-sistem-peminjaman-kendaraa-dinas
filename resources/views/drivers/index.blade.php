@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="shadow-info border-radius-lg pt-4 pb-3" style="background: #013880">
                    <h6 class="text-white text-capitalize ps-3">Driver</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <a data-bs-toggle="modal" data-bs-target="#addDriverModal" class="btn btn-primary mt-3 mx-3">Tambahkan</a>

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


                <div class="card p-3 wrap-text">
                    <div class="table-responsive px-3">
                        <table class="table align-items-center mb-0 text-dark" id="DriverTable">
                            <thead>
                                <tr>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">No.</th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Nama
                                        Driver</th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">No Telp
                                    </th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($drivers as $driver)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}</td>
                                        <td>
                                            {{ $driver->nama_driver }}</td>
                                        <td>
                                            {{ $driver->no_telp }}</td>
                                        <td>
                                            <div class="d-flex align-middle justify-content-center">
                                                <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal"
                                                    data-bs-target="#editDriverModal{{ $driver->id }}">Edit</button>
                                                <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        {{-- tambahkan driver  --}}
        <div class="modal fade" id="addDriverModal" tabindex="-1" aria-labelledby="addDriverModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDriverModalLabel">Add Driver</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('drivers.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Form untuk menambahkan driver -->
                            <div class="mb-3 input-group input-group-static mb-4">
                                <label for="nama_driver" class="form-label ">Nama Driver</label>
                                <input type="text" class="form-control" id="nama_driver" name="nama_driver" required>
                            </div>
                            <div class="mb-3 input-group input-group-static mb-4">
                                <label for="no_telp" class="form-label">No Telp</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
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

        @foreach ($drivers as $driver)
            <div class="modal fade" id="editDriverModal{{ $driver->id }}" tabindex="-1"
                aria-labelledby="editDriverModalLabel{{ $driver->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDriverModalLabel{{ $driver->id }}">Edit Driver</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('drivers.update', $driver->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <!-- Form untuk edit driver -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="nama_driver">Nama Driver</label>
                                    <input type="text" class="form-control" id="nama_driver" name="nama_driver"
                                        value="{{ $driver->nama_driver }}" required>
                                </div>
                                <div class="mb-3 input-group input-group-static mb-4">
                                    <label for="no_telp">No Telp</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp"
                                        value="{{ $driver->no_telp }}" required>
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
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#DriverTable').DataTable();
        });
    </script>
@endpush
