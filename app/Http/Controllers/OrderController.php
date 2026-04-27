<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // DEBUG: Cek user yang login
        \Log::info('ORDER INDEX DEBUG', [
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'user_level' => $user?->level,
            'is_dapur' => $user?->isDapur(),
        ]);

        $ordersQuery = Order::with(['user', 'items.menu']);

        // DEBUG: Log query sebelum filter
        \Log::info('Initial query SQL', ['sql' => $ordersQuery->toSql()]);

        if ($user && $user->isDapur()) {
            $ordersQuery->whereIn('status', ['pending', 'cooking', 'delivered']);
            \Log::info('Applying dapur filter');
        }

        $orders = $ordersQuery->latest()->get();

        // DEBUG: Log hasil query
        \Log::info('Orders retrieved', [
            'count' => count($orders),
            'sql' => $ordersQuery->toSql(),
            'orders' => $orders->map(fn ($o) => [
                'id' => $o->id,
                'order_number' => $o->order_number,
                'status' => $o->status,
            ])->toArray(),
        ]);

        $menus = Menu::with('category')
            ->orderBy('category_id')
            ->get();

        $waiters = User::where('level', 3)->get();

        return view('pages.order.index', compact('orders', 'menus', 'waiters', 'user'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Only owner (1) and cashier (2) can create orders
        if (!$user || !in_array($user->level, [1, 2])) {
            return back()->with('error', 'Anda tidak memiliki akses untuk membuat pesanan.');
        }

        $request->validate([
            'waiter_id' => ['required', Rule::exists('users', 'id')->where(fn($query) => $query->where('level', 3))],
            'table_number' => 'nullable|integer|min:1',
            'items' => 'required|array',
            'items.*.qty' => 'nullable|integer|min:0',
        ]);

        $selectedItems = collect($request->input('items', []))
            ->filter(fn($item) => isset($item['qty']) && (int) $item['qty'] > 0)
            ->map(fn($item, $menuId) => [
                'menu_id' => (int) $menuId,
                'qty' => (int) $item['qty'],
            ]);

        if ($selectedItems->isEmpty()) {
            return back()->withErrors(['items' => 'Pilih minimal 1 menu dengan jumlah lebih dari 0.'])->withInput();
        }

        $menuIds = $selectedItems->pluck('menu_id')->all();
        $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');

        if (count($menuIds) !== $menus->count()) {
            return back()->withErrors(['items' => 'Beberapa menu tidak ditemukan atau tidak valid.'])->withInput();
        }

        $order = Order::create([
            'order_number' => 'ORD' . now()->format('YmdHis') . rand(100, 999),
            'table_number' => $request->input('table_number'),
            'user_id' => $request->input('waiter_id'),
            'total' => 0,
            'status' => 'pending',
        ]);

        $total = 0;

        foreach ($selectedItems as $item) {
            $menu = $menus[$item['menu_id']];
            $subtotal = $menu->harga * $item['qty'];

            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'qty' => $item['qty'],
                'price' => $menu->harga,
                'subtotal' => $subtotal,
            ]);

            $total += $subtotal;
        }

        $order->update(['total' => $total]);

        return redirect()->route('order')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.menu']);

        return view('pages.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,cooking,delivered,completed,cancel',
        ]);

        $order->update(['status' => $request->input('status')]);

        return redirect()->route('order.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function updatePayment(Request $request, Order $order)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user || !in_array($user->level, [1, 2])) {
            return redirect()->route('order.show', $order)->with('error', 'Anda tidak memiliki akses untuk mengubah pembayaran.');
        }

        $request->validate([
            'paid_at' => 'nullable|date',
            'payment_method' => 'required|in:cash,qris',
        ]);

        $paidAtInput = $request->input('paid_at');

        // Parse datetime-local format (Y-m-d\TH:i) and store as Y-m-d H:i
        if ($paidAtInput) {
            try {
                $paidAt = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $paidAtInput);
            } catch (\Exception $e) {
                $paidAt = now();
            }
        } else {
            $paidAt = now();
        }

        $order->update([
            'paid_at' => $paidAt->format('Y-m-d H:i'),
            'payment_method' => $request->input('payment_method'),
        ]);

        return redirect()->route('order.show', $order)->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
