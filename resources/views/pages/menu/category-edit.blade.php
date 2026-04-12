@extends('app')

@section('content')

<style>
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .form-label {
        font-size: 13px;
        color: #888;
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
            <h5 class="mb-0 fw-semibold">Edit Category Menu</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-section mb-3">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Menu</label>
                            <input type="text" name="type_menu" class="form-control"
                                value="{{ old('type_menu', $category->type_menu) }}"
                                placeholder="Contoh: Makanan / Minuman"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori Menu</label>
                            <input type="text" name="cat_menu" class="form-control"
                                value="{{ old('cat_menu', $category->cat_menu) }}"
                                placeholder="Contoh: Nasi / Kopi"
                                required>
                        </div>

                    </div>

                </div>

                <div class="d-flex justify-content-between mt-4">

                    <a href="{{ route('category') }}" class="btn btn-light border px-3">
                        ← Kembali
                    </a>

                    <button type="submit" class="btn btn-coffee px-4">
                        <i class="bi bi-check-circle me-1"></i> Update
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection