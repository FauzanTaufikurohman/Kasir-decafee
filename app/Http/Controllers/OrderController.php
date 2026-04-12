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

        $orders = Order::with(['user', 'items.menu'])
            ->when($user?->isDapur(), function ($query) {
                return $query->whereIn('status', ['pending', 'cooking', 'delivered']);
            })
            ->latest()
            ->get();

        $menus = Menu::with('category')
            ->orderBy('category_id')
            ->get();

        $waiters = User::where('level', 3)->get();

        return view('pages.order.index', compact('orders', 'menus', 'waiters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'waiter_id' => ['required', Rule::exists('users', 'id')->where(fn ($query) => $query->where('level', 3))],
            'table_number' => 'nullable|integer|min:1',
            'items' => 'required|array',
            'items.*.qty' => 'nullable|integer|min:0',
        ]);

        $selectedItems = collect($request->input('items', []))
            ->filter(fn ($item) => isset($item['qty']) && (int) $item['qty'] > 0)
            ->map(fn ($item, $menuId) => [
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
}
