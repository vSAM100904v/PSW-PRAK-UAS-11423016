<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BookingLapangan</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                @if (session('is_logged_in'))
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('product_user') ? 'active' : '' }}" href="{{ route('view_product') }}">Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('lapangan_user') ? 'active' : '' }}" href="{{ route('view_lapangan') }}">Court</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('booking') ? 'active' : '' }}" href="{{ route('booking_info') }}">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('jadwal') ? 'active' : '' }}" href="{{ route('jadwal.index') }}">Informasi Jadwal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('membership/status') ? 'active' : '' }}" href="{{ route('membership.status', ['id_pengguna' => $idPengguna ?? 'id_pengguna']) }}">Beli membership</a>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('product_user') ? 'active' : '' }}" href="{{ route('view_product') }}">Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('lapangan_user') ? 'active' : '' }}" href="{{ route('view_lapangan') }}">Court</a>
                        </li>
                    </ul>
                @endif
                <div class="d-flex align-items-center">
                    @php
                        use App\Helpers\UserHelper;
                    @endphp
                    @if (session('is_logged_in'))
                        <span class="navbar-text text-light me-3">
                            @if (UserHelper::isMember(session('id_pengguna')))
                                Member Status: <span class="badge bg-success">Member</span>
                            @else
                                Member Status: <span class="badge bg-danger">Non-Member</span>
                            @endif
                        </span>
                        <a href="{{ route('cart') }}" class="cart-icon-link text-light me-5">
                            <i class="bi bi-cart-fill cart-icon" aria-hidden="true" style="font-size: 24px;"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light me-2">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="container mt-4">
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="#">@yield('title')</a>
                            @if (session('is_logged_in') && request()->is('/'))                            
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        @yield('dynamic_nav_links')
                                    </ul>
                                </div>
                                <span class="navbar-text">
                                    Welcome, {{ session('username') }}!
                                </span>
                            @else
                                <a class="navbar-brand" href="#"><small>@yield('sub_title')</small></a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        @yield('dynamic_nav_links')
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </nav>
                </div>
            </header>

            <hr />
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="px-4 py-6 sm:px-0">
                    <div class="border-4 border-dashed border-gray-200 rounded-lg h-96">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="container mt-4">
        <div>@yield('contents')</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pF9xv3JhNhJ5jUvDYpMDy5k3gnh+o34s+5BktmRVXHh/bT9jpBn8BvWBf5SL+xI1" crossorigin="anonymous">
    </script>
</body>

</html>
