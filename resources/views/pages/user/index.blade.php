@extends('app')
@section('content')

    <div class="col-lg-9 mt-2" style="max-height: 80vh; overflow-y: auto;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @php
            $levels = [
                1 => 'Super Admin',
                2 => 'Kasir',
                3 => 'Pelayan',
                4 => 'Dapur'
            ];
        @endphp
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <i class="bi bi-people me-2"></i>User
            </div>
            <div class="card-body">
                <h5 class="card-title">Manajemen User</h5>
                <p class="card-text">Kelola data pelanggan Anda dengan mudah.</p>
                <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
                    <i class="bi bi-plus-circle me-2"></i>Tambah User
                </button>
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td scope="row">{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>


                                <td>
                                    {{ $levels[$user->level] ?? 'Unknown' }}
                                </td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}" class="text-white btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>


                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Create -->
    <div class="modal fade" id="modalCreateUser" tabindex="-1" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateUserLabel">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Level User</label>
                            <select name="level" class="form-control" required>
                                <option value="" disabled selected>Pilih Level User</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Kasir</option>
                                <option value="3">Pelayan</option>
                                <option value="4">Dapur</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-coffee">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection