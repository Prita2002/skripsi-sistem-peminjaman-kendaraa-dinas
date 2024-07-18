<!-- resources/views/partials/user-detail.blade.php -->
<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">User Details</h6>
        </div>
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>
        <p><strong>NIP:</strong> {{ $user->nip }}</p>
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><strong>No. Telepon:</strong> {{ $user->no_telp }}</p>
        <p><strong>Tim Kerja:</strong> {{ $user->timKerja->nama ?? 'N/A' }}</p>
    </div>
</div>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
<a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
