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
                <span
                    class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'cooking' ? 'info' : ($order->status === 'delivered' ? 'primary' : ($order->status === 'completed' ? 'success' : 'danger'))) }}">
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

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @php
                    $user = Auth::user();
                    $canManageStatus = $user && in_array($user->level, [1, 3, 4]);
                @endphp

                @if ($canManageStatus)
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
                            <h6 class="text-muted">Status Pembayaran</h6>
                            @if ($order->paid_at)
                                <p class="mb-0">
                                    <span class="badge bg-success">Sudah Dibayar</span>
                                </p>
                                <small class="text-muted d-block mt-2">
                                    {{ $order->paid_at->format('d/m/Y H:i') }}
                                    @if ($order->payment_method)
                                        <br><span class="badge bg-info">{{ strtoupper($order->payment_method) }}</span>
                                    @endif
                                </small>
                            @else
                                <p class="mb-0">
                                    <span class="badge bg-warning">Belum Dibayar</span>
                                </p>
                            @endif
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

                @php
                    $user = Auth::user();
                    $canManagePayment = $user && in_array($user->level, [1, 2]);
                @endphp

                @if ($canManagePayment)
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="mb-3">
                            <i class="bi bi-credit-card"></i> Kelola Pembayaran
                        </h6>
                        <form action="{{ route('order.payment', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror"
                                        id="payment_method" name="payment_method" required>
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="cash" {{ $order->payment_method === 'cash' ? 'selected' : '' }}>
                                            Tunai (Cash)
                                        </option>
                                        <option value="qris" {{ $order->payment_method === 'qris' ? 'selected' : '' }}>
                                            QRIS
                                        </option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="paid_at" class="form-label">Waktu Pembayaran</label>
                                    <input type="datetime-local"
                                        class="form-control @error('paid_at') is-invalid @enderror" id="paid_at"
                                        name="paid_at"
                                        value="{{ $order->paid_at ? $order->paid_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i') }}">
                                    @error('paid_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                @if ($order->paid_at)
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Update Pembayaran
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle"></i> Tandai Sudah Dibayar
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
