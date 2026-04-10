@extends('app')

@section('content')
    <div class="col-lg-9 mt-2">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-house-door me-2"></i>Dashboard
            </div>
            <div class="card-body">
                <h5 class="card-title">Selamat Datang di Dashboard</h5>
                <p class="card-text">Kelola penjualan Anda dengan mudah melalui sistem kasir Putra Coffee. Gunakan menu di
                    samping untuk mengakses fitur-fitur yang tersedia.</p>
                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="card-title">Total Order</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="card-title">Total Pelanggan</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="card-title">Total Produk</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="card-title">Pendapatan</h6>
                                <h3>Rp 0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection