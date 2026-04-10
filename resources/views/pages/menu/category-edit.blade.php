@extends('app')

@section('content')
    <div class="col-lg-9 mt-3" style="max-height: 80vh; overflow-y: auto;">

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-coffee text-dark">
                <i class="bi bi-pencil-square me-2"></i>Edit Category Menu
            </div>

            <div class="card-body">

                <form action="{{ route('category.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('category') }}" class="btn btn-outline-secondary">
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