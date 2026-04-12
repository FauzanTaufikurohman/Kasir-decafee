@extends('app')

@section('content')
    <style>
        .card-modern {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-size: 13px;
            color: #888;
        }

        .img-preview {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #eee;
        }

        .form-section {
            background: #fafafa;
            border-radius: 12px;
            padding: 15px;
        }
    </style>

    <div class="col-lg-9 mt-4" style="max-height: 80vh; overflow-y: auto;">

        <div class="card card-modern">


            <div class="card-body border-bottom d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-muted"></i>
                <h5 class="mb-0 fw-semibold">Edit Menu</h5>
            </div>


            <div class="card-body">

                <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $menu->name) }}"
                            required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Gambar</label>

                        <div class="d-flex align-items-center gap-3">


                            @if ($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" class="img-preview">
                            @else
                                <div class="img-preview d-flex align-items-center justify-content-center text-muted">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif


                            <div class="flex-grow-1">
                                <input type="file" name="image" class="form-control">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                            </div>

                        </div>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="desc" rows="3" class="form-control" required>{{ old('desc', $menu->desc) }}</textarea>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option disabled>Pilih kategori</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->cat_menu }} ({{ $category->type_menu }})
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-section mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control"
                                    value="{{ old('harga', $menu->harga) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control"
                                    value="{{ old('stok', $menu->stok) }}" required>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-between mt-4">

                        <a href="{{ route('menu') }}" class="btn btn-light border px-3">
                            ← Kembali
                        </a>

                        <button type="submit" class="btn btn-coffee px-4">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
