@php
    $level = auth()->user()->level;

    $menuItems = [
        'dashboard' => ['icon' => 'bi-house-door', 'label' => 'Dashboard', 'access' => [1]],
        'menu' => ['icon' => 'bi-egg-fried', 'label' => 'Menu', 'access' => [1, 2, 3]],
        'category' => ['icon' => 'bi-list', 'label' => 'Category', 'access' => [1]],
        'order' => ['icon' => 'bi-cart-check', 'label' => 'Order', 'access' => [1, 2, 3, 4]],
        'customer' => ['icon' => 'bi-person', 'label' => 'Customer', 'access' => [1]],
        'user' => ['icon' => 'bi-person', 'label' => 'User', 'access' => [1]],
        'product' => ['icon' => 'bi-cup-hot', 'label' => 'Product', 'access' => [1]],
        'report' => ['icon' => 'bi-bar-chart-line', 'label' => 'Report', 'access' => [1]],
    ];
@endphp

<div class="col-lg-3">
    <nav class="navbar navbar-expand-lg bg-body-tertiary rounded border mt-2">
        <div class="container-fluid">

            <!-- Toggle Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Sidebar -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" style="width:250px;">

                <!-- Header -->
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>

                <!-- Body -->
                <div class="offcanvas-body">
                    <ul class="navbar-nav flex-column flex-grow-1">

                        @foreach ($menuItems as $key => $item)
                            @if (in_array($level, $item['access']))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs($key) ? 'active fw-bold text-primary' : '' }}"
                                        href="{{ route($key) }}">
                                        <i class="bi {{ $item['icon'] }} me-2"></i>
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach

                    </ul>
                </div>

            </div>
        </div>
    </nav>
</div>