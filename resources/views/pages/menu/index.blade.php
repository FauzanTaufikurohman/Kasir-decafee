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
                <i class="bi bi-people me-2"></i>Menu
            </div>
            <div class="card-body">
                <h5 class="card-title">Manajemen Menu</h5>
                <p class="card-text">Kelola data daftar menu anda dengan mudah.</p>
                <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#modalCreateMenu">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Menu Makanan
                </button>
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr>
                                <td scope="row">{{ $menu->id }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>
                                    @if($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" width="100">
                                    @else
                                        Tidak ada gambar
                                    @endif
                                </td>
                                <td>{{ $menu->desc }}</td>
                                <td>
                                    {{ $menu->category->name ?? 'Tidak ada kategori' }}
                                </td>
                                <td>
                                    {{ $menu->harga }}
                                </td>
                                <td>
                                    {{ $menu->stok }}
                                </td>
                                <td>
                                    <a href="{{ route('menu.edit', $menu->id) }}" class="text-white btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>


                                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus menu ini?')">
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

                <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- HEADER --}}
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold">
                            Tambah Menu
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    {{-- BODY --}}
                    <div class="modal-body pt-3">

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted">Nama Menu</label>
                            <input type="text" name="name" class="form-control form-control-sm"
                                placeholder="Contoh: Nasi Goreng" required>
                        </div>

                        {{-- Gambar --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted">Gambar</label>
                            <input type="file" name="image" class="form-control form-control-sm" accept="image/*" required>
                            <small class="text-muted">Format: jpg, png (max 2MB)</small>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted">Deskripsi</label>
                            <textarea name="desc" rows="2" class="form-control form-control-sm"
                                placeholder="Deskripsi singkat menu..." required></textarea>
                        </div>

                        {{-- Category --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted">Kategori</label>
                            <select name="category" class="form-select form-select-sm" required>
                                <option value="" disabled selected>Pilih kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Harga & Stok (grid) --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-muted">Harga</label>
                                <input type="number" name="harga" class="form-control form-control-sm" placeholder="Rp"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-muted">Stok</label>
                                <input type="number" name="stok" class="form-control form-control-sm" placeholder="Jumlah"
                                    required>
                            </div>
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