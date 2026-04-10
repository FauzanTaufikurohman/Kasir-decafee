@extends('app')
@section('content')
<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header">
            <i class="bi bi-people me-2"></i>Customer
        </div>
        <div class="card-body">
            <h5 class="card-title">Manajemen Customer</h5>
            <p class="card-text">Kelola data pelanggan Anda dengan mudah.</p>
            <button class="btn btn-coffee">
                <i class="bi bi-plus-circle me-2"></i>Tambah Customer
            </button>
            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data customer</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection