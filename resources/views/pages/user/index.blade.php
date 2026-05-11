@extends('app')
@section('content')

    <style>
        .card-modern {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .table-modern th {
            font-size: 13px;
            color: #888;
            font-weight: 500;
        }

        .table-modern td {
            vertical-align: middle;
            font-size: 14px;
        }

        .badge-role {
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
        }

        .role-1 {
            background: #ede6e0;
            color: #4B2E2B;
        }

        .role-2 {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .role-3 {
            background: #e3f2fd;
            color: #1565c0;
        }

        .role-4 {
            background: #fff3e0;
            color: #ef6c00;
        }

        .alert-modern {
            border: none;
            border-radius: 12px;
        }
    </style>

    <div class="col-lg-9 mt-3" style="max-height: 80vh; overflow-y: auto;">


        @if (session('success'))
            <div class="alert alert-success alert-modern alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-modern alert-dismissible fade show">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @php
            $levels = [
                1 => 'Super Admin',
                2 => 'Kasir',
                3 => 'Admin',
                4 => 'Dapur',
            ];
        @endphp


        <div class="card card-modern">

            <div class="card-body">


                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-semibold mb-1">Manajemen User</h5>
                        <small class="text-muted">Kelola pengguna sistem</small>
                    </div>

                    <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-modern table-hover align-middle">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>


                                    <td class="fw-semibold">
                                        {{ $user->name }}
                                    </td>


                                    <td class="text-muted">
                                        {{ $user->email }}
                                    </td>

                                    <td>
                                        <span class="badge-role role-{{ $user->level }}">
                                            {{ $levels[$user->level] ?? 'Unknown' }}
                                        </span>
                                    </td>

                                    <td class="text-end">

                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-light border">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-light border text-danger"
                                                onclick="return confirm('Hapus user ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada user
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

    <div class="modal fade" id="modalCreateUser" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 16px;">

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="modal-header border-0">
                        <h5 class="fw-semibold">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label small text-muted">Nama</label>
                            <input type="text" name="name" class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Email</label>
                            <input type="email" name="email" class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Password</label>
                            <input type="password" name="password" class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-sm"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Level User</label>
                            <select name="level" class="form-select form-select-sm" required>
                                <option disabled selected>Pilih Level</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Kasir</option>
                                <option value="3">Admin</option>
                                <option value="4">Dapur</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-coffee btn-sm px-4">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
