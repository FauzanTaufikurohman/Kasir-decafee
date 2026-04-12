<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalMenus = Menu::count();
        $totalCategories = Category::count();
        $totalStaff = User::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');

        $orderStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('pages.dashboard', compact(
            'totalOrders',
            'totalMenus',
            'totalCategories',
            'totalStaff',
            'totalRevenue',
            'orderStatus',
            'recentOrders'
        ));
    }
}
