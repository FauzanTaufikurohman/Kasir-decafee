@extends('app')
@section('content')
<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header">
            <i class="bi bi-cup-hot me-2"></i>Product
        </div>
        <div class="card-body">
            <h5 class="card-title">Manajemen Produk</h5>
            <p class="card-text">Kelola katalog produk Putra Coffee.</p>
            <button class="btn btn-coffee">
                <i class="bi bi-plus-circle me-2"></i>Tambah Produk
            </button>
            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data produk</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection