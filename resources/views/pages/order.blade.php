@extends('app')

@section('content')
    <div class="col-lg-9 mt-2">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-cart-check me-2"></i>Order
            </div>
            <div class="card-body">
                <h5 class="card-title">Manajemen Order</h5>
                <p class="card-text">Kelola pesanan pelanggan Anda. Tambahkan, edit, atau lihat detail pesanan.</p>
                <button class="btn btn-coffee">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Order
                </button>
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data order</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection