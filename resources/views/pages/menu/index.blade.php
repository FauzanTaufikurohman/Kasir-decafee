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

        .img-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .badge-soft {
            background: #f1f1f1;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
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


        <div class="card card-modern">

            <div class="card-body">
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-semibold mb-1">Manajemen Menu</h5>
                        <small class="text-muted">Kelola daftar menu restoran</small>
                    </div>

                    @if (auth()->user()->level !== 2)
                        <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#modalCreateMenu">
                            <i class="bi bi-plus-lg me-1"></i> Tambah
                        </button>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-modern table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Menu</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                @if (auth()->user()->level !== 2)
                                    <th class="text-end">Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($menus as $menu)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            @if ($menu->image)
                                                <img src="{{ asset('storage/' . $menu->image) }}" class="img-thumb">
                                            @else
                                                <div
                                                    class="img-thumb d-flex align-items-center justify-content-center text-muted">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="fw-semibold">{{ $menu->name }}</div>
                                                <small class="text-muted">
                                                    {{ Str::limit($menu->desc, 40) }}
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge-soft">
                                            {{ $menu->category->cat_menu ?? '-' }}
                                        </span>
                                    </td>


                                    <td class="fw-semibold text-success">
                                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                    </td>


                                    <td>
                                        <span class="badge-soft">
                                            {{ $menu->stok }}
                                        </span>
                                    </td>

                                    @if (auth()->user()->level !== 2)
                                        <td class="text-end">
                                            <a href="{{ route('menu.edit', $menu->id) }}"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('menu.destroy', $menu->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-light border text-danger"
                                                    onclick="return confirm('Hapus menu ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data menu
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>


    <div class="modal fade" id="modalCreateMenu" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 16px;">

                <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (auth()->user()->level !== 3)
                        <div class="modal-header border-0">
                            <h5 class="fw-semibold">Tambah Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    @endif

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label small text-muted">Nama</label>
                            <input type="text" name="name" class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Gambar</label>
                            <input type="file" name="image" class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Deskripsi</label>
                            <textarea name="desc" class="form-control form-control-sm" rows="2" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Kategori</label>
                            <select name="category" class="form-select form-select-sm" required>
                                <option disabled selected>Pilih kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->cat_menu }} ({{ $category->type_menu }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-muted">Harga</label>
                                <input type="number" name="harga" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-muted">Stok</label>
                                <input type="number" name="stok" class="form-control form-control-sm" required>
                            </div>
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
