@php
    $level = auth()->user()->level;

    $menuItems = [
        'dashboard' => ['icon' => 'bi-house-door', 'label' => 'Dashboard', 'access' => [1, 2]],
        'menu' => ['icon' => 'bi-egg-fried', 'label' => 'Menu', 'access' => [1, 2, 3, 4]],
        'category' => ['icon' => 'bi-list', 'label' => 'Category', 'access' => [1, 3]],
        'order' => ['icon' => 'bi-cart-check', 'label' => 'Order', 'access' => [1, 2, 3, 4]],
        'user' => ['icon' => 'bi-person', 'label' => 'User', 'access' => [1]],
    ];
@endphp

<div class="col-lg-3">
    <nav class="navbar navbar-expand-lg mt-3">

        <div class="container-fluid p-0">

            <!-- Toggle -->
            <button class="navbar-toggler shadow-sm" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Sidebar -->
            <div class="offcanvas offcanvas-start sidebar-modern" tabindex="-1" id="offcanvasNavbar">

               

                <!-- Body -->
                <div class="offcanvas-body d-flex flex-column">

                    <ul class="navbar-nav flex-column gap-1">

                        @foreach ($menuItems as $key => $item)
                            @if (in_array($level, $item['access']))
                                <li class="nav-item">
                                    <a class="nav-link sidebar-link {{ request()->routeIs($key) ? 'active' : '' }}"
                                        href="{{ route($key) }}">

                                        <div class="icon-wrapper">
                                            <i class="bi {{ $item['icon'] }}"></i>
                                        </div>

                                        <span>{{ $item['label'] }}</span>
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