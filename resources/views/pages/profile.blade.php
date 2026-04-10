@extends('app')

@section('content')
<div class="col-lg-9 mt-4" style="max-height: 80vh; overflow-y: auto;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <h4 class="mb-4 fw-bold">Ubah Akun</h4>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name', $user->name) }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Masukkan nama"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Masukkan email"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <h6 class="mb-3 text-muted">Ubah Password</h6>

                {{-- Password Lama --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password Lama</label>
                    <input 
                        type="password" 
                        name="current_password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        placeholder="Masukkan password lama"
                    >
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password Baru</label>
                    <input 
                        type="password" 
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Kosongkan jika tidak ingin mengubah"
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Ulangi password baru"
                    >
                </div>

                {{-- Button --}}
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        Kembali
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