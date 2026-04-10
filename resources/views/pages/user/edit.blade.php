@extends('app')

@section('content')
    <div class="col-lg-9 mt-3" style="max-height: 80vh; overflow-y: auto;">

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-coffee text-dark">
                <i class="bi bi-pencil-square me-2"></i>Edit User
            </div>

            <div class="card-body">

                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Level User</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                <select name="level" class="form-control" required>
                                    <option value="1" {{ $user->level == 1 ? 'selected' : '' }}>Super Admin</option>
                                    <option value="2" {{ $user->level == 2 ? 'selected' : '' }}>Kasir</option>
                                    <option value="3" {{ $user->level == 3 ? 'selected' : '' }}>Pelayan</option>
                                    <option value="4" {{ $user->level == 4 ? 'selected' : '' }}>Dapur</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <p class="text-muted"><small>Kosongkan password jika tidak ingin mengubah</small></p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        <button type="submit" class="btn btn-coffee px-4">
                            <i class="bi bi-save me-1"></i> Update
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection