@extends('app')
@section('content')

    <div class="col-lg-9 mt-2" style="max-height: 80vh; overflow-y: auto;">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-basket me-2"></i>Order
                </div>
                @if (!optional(auth()->user())->isDapur())
                    <button class="btn btn-coffee btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateOrder">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Pesanan
                    </button>
                @endif
            </div>

            <div class="card-body">
                <h5 class="card-title">Daftar Pesanan</h5>
                <p class="card-text">Lihat status dan detail pesanan yang sudah dibuat.</p>

                <div class="row g-3 align-items-end mb-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Cari Pesanan</label>
                        <input id="tableSearch" type="search" class="form-control form-control-sm"
                            placeholder="Cari nomor pesanan, pelayan, atau meja...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Filter Status</label>
                        <select id="statusFilter" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Sedang Dimasak">Sedang Dimasak</option>
                            <option value="Diantarkan">Diantarkan</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Batal">Batal</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <button id="resetFilter" type="button" class="btn btn-outline-secondary btn-sm w-100">
                            Reset
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="ordersTable" class="table table-hover mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Pesanan</th>
                                <th>No Meja</th>
                                <th>Pelayan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->table_number ?? '-' }}</td>
                                    <td>{{ $order->user->name ?? 'Tidak ada pelayan' }}</td>
                                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $badge = 'secondary';
                                            $label = 'Unknown';

                                            if ($order->status === 'pending') {
                                                $badge = 'warning';
                                                $label = 'Pending';
                                            } elseif ($order->status === 'cooking') {
                                                $badge = 'info';
                                                $label = 'Sedang Dimasak';
                                            } elseif ($order->status === 'delivered') {
                                                $badge = 'primary';
                                                $label = 'Diantarkan';
                                            } elseif ($order->status === 'completed') {
                                                $badge = 'success';
                                                $label = 'Selesai';
                                            } elseif ($order->status === 'cancel') {
                                                $badge = 'danger';
                                                $label = 'Batal';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('order.show', $order) }}" class="btn btn-sm btn-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada pesanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Order -->
    <div class="modal fade" id="modalCreateOrder" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold">Tambah Pesanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body pt-3">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label small text-muted">No Meja (opsional)</label>
                                <input type="number" name="table_number" class="form-control form-control-sm"
                                    value="{{ old('table_number') }}" placeholder="Contoh: 5">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Pelayan</label>
                                <select name="waiter_id" class="form-select form-select-sm" required>
                                    <option value="" disabled {{ old('waiter_id') ? '' : 'selected' }}>Pilih pelayan</option>
                                    @foreach ($waiters as $waiter)
                                        <option value="{{ $waiter->id }}" {{ old('waiter_id') == $waiter->id ? 'selected' : '' }}>
                                            {{ $waiter->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive" style="max-height: 50vh; overflow-y: auto;">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Menu</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($menus as $menu)
                                        <tr>
                                            <td>{{ $menu->name }}</td>
                                            <td>{{ $menu->category->cat_menu ?? '-' }}</td>
                                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                            <td>{{ $menu->stok }}</td>
                                            <td style="width: 120px;">
                                                <input type="number"
                                                    name="items[{{ $menu->id }}][qty]"
                                                    class="form-control form-control-sm"
                                                    min="0"
                                                    max="{{ $menu->stok }}"
                                                    value="{{ old('items.' . $menu->id . '.qty', 0) }}"
                                                    {{ $menu->stok === 0 ? 'disabled' : '' }}>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                Tidak ada menu tersedia.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-coffee btn-sm px-4">
                            Simpan Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#ordersTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            ordering: true,
            searching: true,
            responsive: true,
            dom: 'tip',
            language: {
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                paginate: {
                    previous: '‹',
                    next: '›'
                },
                zeroRecords: 'Data tidak ditemukan'
            },
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1 + meta.settings._iDisplayStart;
                    }
                },
                {
                    targets: 5,
                    orderable: false,
                }
            ]
        });

        $('#tableSearch').on('keyup change', function () {
            table.search(this.value).draw();
        });

        $('#statusFilter').on('change', function () {
            table.column(5).search(this.value).draw();
        });

        $('#resetFilter').on('click', function () {
            $('#tableSearch').val('');
            $('#statusFilter').val('');
            table.search('').columns().search('').draw();
        });
    });
</script>