@extends('app')

@section('content')
    <div class="col-lg-9 mt-4" style="max-height: 80vh; overflow-y: auto;">

        <div class="card shadow-sm border-0 rounded-3">

            {{-- HEADER --}}
            <div class="card-header bg-coffee text-white">
                <i class="bi bi-pencil-square me-2"></i>Edit Menu
            </div>

            <div class="card-body">

                <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama Menu</label>
                        <input type="text" name="name" class="form-control form-control-sm"
                            value="{{ old('name', $menu->name) }}" required>
                    </div>

                    {{-- Gambar --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted">Gambar</label>

                        {{-- Preview gambar lama --}}
                        @if($menu->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $menu->image) }}" width="100" class="rounded">
                            </div>
                        @endif

                        <input type="file" name="image" class="form-control form-control-sm" accept="image/*">

                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted">Deskripsi</label>
                        <textarea name="desc" rows="2" class="form-control form-control-sm"
                            required>{{ old('desc', $menu->desc) }}</textarea>
                    </div>

                    {{-- Category --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted">Kategori</label>
                        <select name="category_id" class="form-select form-select-sm" required>
                            <option value="" disabled>Pilih kategori</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Harga & Stok --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-muted">Harga</label>
                            <input type="number" name="harga" class="form-control form-control-sm"
                                value="{{ old('harga', $menu->harga) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-muted">Stok</label>
                            <input type="number" name="stok" class="form-control form-control-sm"
                                value="{{ old('stok', $menu->stok) }}" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 d-flex justify-content-between"> <button type="button"
                            class="btn btn-light btn-sm px-3" data-bs-dismiss="modal"> Batal </button> <button type="submit"
                            class="btn btn-coffee btn-sm px-4"> Simpan </button> </div>
                </form>
            </div>
        </div>

    </div>
@endsection