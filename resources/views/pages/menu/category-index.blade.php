@extends('app')
@section('content')

    <div class="col-lg-9 mt-2" style="max-height: 80vh; overflow-y: auto;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
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
                <i class="bi bi-people me-2"></i>Category Menu
            </div>
            <div class="card-body">
                <h5 class="card-title">Manajemen Category</h5>
                <p class="card-text">Kelola data daftar category anda dengan mudah.</p>
                <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#modalCreateMenu">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Category
                </button>
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td scope="row">{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ route('category.show', $category->id) }}"
                                        class="text-white btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>


                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus category ini?')">
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
    <div class="modal fade" id="modalCreateMenu" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- HEADER --}}
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold">
                            Tambah Category Menu
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    {{-- BODY --}}
                    <div class="modal-body pt-3">

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted">Nama Category</label>
                            <input type="text" name="name" class="form-control form-control-sm"
                                placeholder="Contoh: Makanan" required>
                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">
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