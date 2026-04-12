@extends('app')
@section('content')

<style>
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
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

    .badge-soft {
        background: #f1f1f1;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
    }

    .alert-modern {
        border-radius: 12px;
        border: none;
    }
</style>

<div class="col-lg-9 mt-3"  style="max-height: 80vh; overflow-y: auto;">

    @if(session('success'))
        <div class="alert alert-success alert-modern alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-modern alert-dismissible fade show">
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
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
                    <h5 class="fw-semibold mb-1">Category Menu</h5>
                    <small class="text-muted">Kelola kategori menu restoran</small>
                </div>

                <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#modalCreateMenu">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-modern table-hover align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jenis Menu</th>
                            <th>Kategori</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="badge-soft">
                                    {{ $category->type_menu }}
                                </span>
                            </td>

                            <td class="fw-semibold">
                                {{ $category->cat_menu }}
                            </td>

                            <td class="text-end">

                                <a href="{{ route('category.show', $category->id) }}"
                                    class="btn btn-sm btn-light border">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('category.destroy', $category->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-light border text-danger"
                                        onclick="return confirm('Hapus category ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada data kategori
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

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="modal-header border-0">
                    <h5 class="fw-semibold">Tambah Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label small text-muted">Jenis Menu</label>
                        <input type="text" name="type_menu" class="form-control form-control-sm"
                            placeholder="Contoh: Makanan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Kategori Menu</label>
                        <input type="text" name="cat_menu" class="form-control form-control-sm"
                            placeholder="Contoh: Nasi" required>
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