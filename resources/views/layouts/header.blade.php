<!-- Header Navbar -->
<nav class="navbar navbar-expand coffee-navbar shadow-sm sticky-top">
    <div class="container-lg">
        <a class="navbar-brand d-flex align-items-center" href="../">
            <img src="{{ asset('images/logo.webp') }}" alt="Logo" width="35" height="35" class="me-2">
            <span class="fw-semibold">Origin Cafee</span>
        </a>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-medium" href="#" role="button" data-bs-toggle="dropdown">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 coffee-dropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="bi bi-person-circle me-2"></i>
                                Profile
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>