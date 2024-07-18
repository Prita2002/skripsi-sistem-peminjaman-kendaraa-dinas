<div class="input-group input-group-static mb-4">
    <label for="name">Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        value="{{ old('name', $user->name) }}" required>
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="input-group input-group-static mb-4">
    <label for="email">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
        value="{{ old('email', $user->email) }}" required>
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="input-group input-group-static mb-4">
    <label for="password">Password</label>
    <input type="password" class="p-2 form-control @error('password') is-invalid @enderror" id="password"
        name="password">
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="input-group input-group-static mb-4">
    <label for="password_confirmation">Confirm Password</label>
    <input type="password" class=" p-2 form-control" id="password_confirmation" name="password_confirmation">
</div>

<div class="input-group input-group-static mb-4">
    <label for="nip">NIP</label>
    <input type="text" class=" p-2 form-control @error('nip') is-invalid @enderror" id="nip" name="nip"
        value="{{ old('nip', $user->nip) }}" required>
    @error('nip')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="input-group input-group-static mb-4">
    <label for="username">Username</label>
    <input type="text" class=" p-2 form-control @error('username') is-invalid @enderror" id="username"
        name="username" value="{{ old('username', $user->username) }}" required>
    @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="mb-4">
    <label for="role">Role</label>
    <select class="p-2 form-select @error('role') is-invalid @enderror" id="role" name="role" required>
        <option value="" disabled {{ old('role', $user->role) == '' ? 'selected' : '' }}>Select Role</option>
        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
    </select>
    @error('role')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="input-group input-group-static mb-4">
    <label for="no_telp">No. Telepon</label>
    <input type="text" class=" p-2 form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp"
        value="{{ old('no_telp', $user->no_telp) }}" required>
    @error('no_telp')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="mb-4">
    <label for="tim_kerja_id">Tim Kerja</label>
    <select class="p-2 form-select @error('tim_kerja_id') is-invalid @enderror" id="tim_kerja_id" name="tim_kerja_id"
        required>
        <option value="" disabled {{ old('tim_kerja_id', $user->tim_kerja_id ?? '') == '' ? 'selected' : '' }}>
            Select Tim Kerja</option>
        @foreach ($timKerjas as $timKerja)
            <option class="" value="{{ $timKerja->id }}"
                {{ old('tim_kerja_id', $user->tim_kerja_id ?? '') == $timKerja->id ? 'selected' : '' }}>
                {{ $timKerja->nama }}
            </option>
        @endforeach
    </select>
    @error('tim_kerja_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
