@extends('app')
@section('content')

    <div class="col-lg-9 mt-2" style="max-height: 80vh; overflow-y: auto;">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <a href="{{ route('order') }}" class="btn btn-sm btn-light me-2">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    Detail Pesanan
                </div>
                <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'cooking' ? 'info' : ($order->status === 'delivered' ? 'primary' : ($order->status === 'completed' ? 'success' : 'danger'))) }}">
                    {{ $order->status === 'pending' ? 'Pending' : ($order->status === 'cooking' ? 'Sedang Dimasak' : ($order->status === 'delivered' ? 'Diantarkan' : ($order->status === 'completed' ? 'Selesai' : 'Batal'))) }}
                </span>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($order->status !== 'cancel' && $order->status !== 'completed')
                    <div class="mb-4 d-flex gap-2">
                        @if ($order->status === 'pending')
                            <form action="{{ route('order.status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cooking">
                                <button type="submit" class="btn btn-info btn-sm">Mulai Masak</button>
                            </form>
                        @endif

                        @if ($order->status === 'cooking')
                            <form action="{{ route('order.status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="delivered">
                                <button type="submit" class="btn btn-primary btn-sm">Diantarkan</button>
                            </form>
                        @endif

                        @if ($order->status === 'delivered')
                            <form action="{{ route('order.status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                            </form>
                        @endif

                        <form action="{{ route('order.status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancel">
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin batalkan pesanan ini?')">
                                Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                @endif
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h6 class="text-muted">No Pesanan</h6>
                            <p class="mb-0">{{ $order->order_number }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h6 class="text-muted">No Meja</h6>
                            <p class="mb-0">{{ $order->table_number ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h6 class="text-muted">Pelayan</h6>
                            <p class="mb-0">{{ $order->user->name ?? 'Tidak ada pelayan' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h6 class="text-muted">Total</h6>
                            <p class="mb-0">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h6 class="text-muted">Dibuat</h6>
                            <p class="mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h6 class="text-muted">Dibayar</h6>
                            <p class="mb-0">{{ $order->paid_at ? $order->paid_at->format('d/m/Y H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->menu->name ?? 'Menu tidak ditemukan' }}</td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada item pada pesanan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
