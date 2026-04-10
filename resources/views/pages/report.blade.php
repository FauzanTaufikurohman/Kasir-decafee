@extends('app')
@section('content')
<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header">
            <i class="bi bi-bar-chart-line me-2"></i>Report
        </div>
        <div class="card-body">
            <h5 class="card-title">Laporan Penjualan</h5>
            <p class="card-text">Lihat statistik dan laporan penjualan Anda.</p>
            <form class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hingga Tanggal</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-coffee w-100">
                        <i class="bi bi-search me-2"></i>Filter
                    </button>
                </div>
            </form>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Order</th>
                        <th>Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" class="text-center text-muted">Tidak ada data report</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection