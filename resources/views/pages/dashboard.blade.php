@extends('app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .card-modern {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
        }

        .stat-label {
            font-size: 13px;
            color: #888;
        }

        .badge-modern {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .table-modern th {
            font-size: 13px;
            color: #777;
            font-weight: 500;
        }

        .table-modern td {
            vertical-align: middle;
            font-size: 14px;
        }

        .gradient-card {
            background: linear-gradient(135deg, #6F4E37, #4B2E2B);
            color: #fff;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="col-lg-9 mt-3 fade-in" style="max-height: 80vh; overflow-y: auto;">
        <div class="card card-modern p-3">

            <div class="mb-3">
                <h4 class="fw-bold">Dashboard</h4>
                <p class="text-muted">Ringkasan operasional restoran secara real-time</p>
            </div>

            <div class="row g-3">

                <div class="col-md-3" data-aos="fade-up">
                    <div class="card card-modern text-center p-3">
                        <div class="stat-label">Total Pesanan</div>
                        <div class="stat-number">{{ $totalOrders }}</div>
                    </div>
                </div>

                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-modern text-center p-3">
                        <div class="stat-label">Total Menu</div>
                        <div class="stat-number">{{ $totalMenus }}</div>
                    </div>
                </div>

                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-modern text-center p-3">
                        <div class="stat-label">Kategori</div>
                        <div class="stat-number">{{ $totalCategories }}</div>
                    </div>
                </div>

                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card card-modern text-center p-3">
                        <div class="stat-label">Staf</div>
                        <div class="stat-number">{{ $totalStaff }}</div>
                    </div>
                </div>

            </div>

            <div class="row mt-4 g-3">

                @php
                    $statuses = [
                        'pending' => ['label' => 'Pending', 'color' => 'warning'],
                        'cooking' => ['label' => 'Dimasak', 'color' => 'info'],
                        'delivered' => ['label' => 'Diantar', 'color' => 'primary'],
                        'completed' => ['label' => 'Selesai', 'color' => 'success'],
                        'cancel' => ['label' => 'Batal', 'color' => 'danger'],
                    ];
                @endphp

                @foreach ($statuses as $key => $s)
                    <div class="col-md-4" data-aos="zoom-in">
                        <div class="card card-modern p-3 border-start border-4 border-{{ $s['color'] }}">
                            <div class="stat-label">{{ $s['label'] }}</div>
                            <div class="stat-number">{{ $orderStatus[$key] ?? 0 }}</div>
                        </div>
                    </div>
                @endforeach

                <div class="col-md-4" data-aos="zoom-in">
                    <div class="card card-modern gradient-card text-center p-3">
                        <div class="stat-label text-white">Pendapatan</div>
                        <div class="stat-number">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-4">

                <div class="col-md-8">
                    <div class="card card-modern">
                        <div class="card-header bg-white border-0 fw-semibold">
                            Pesanan Terbaru
                        </div>

                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No</th>
                                        <th>Pelayan</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($recentOrders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->user->name ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $map = [
                                                        'pending' => 'warning',
                                                        'cooking' => 'info',
                                                        'delivered' => 'primary',
                                                        'completed' => 'success',
                                                        'cancel' => 'danger',
                                                    ];
                                                @endphp

                                                <span
                                                    class="badge bg-{{ $map[$order->status] ?? 'secondary' }} badge-modern">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                Rp {{ number_format($order->total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">
                                                Belum ada data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-modern p-3">

                        <h6 class="fw-semibold mb-3">Statistik</h6>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Menu</span>
                            <strong>{{ $totalMenus }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Kategori</span>
                            <strong>{{ $totalCategories }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Staf</span>
                            <strong>{{ $totalStaff }}</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Revenue</span>
                            <strong class="text-success">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
@endsection
