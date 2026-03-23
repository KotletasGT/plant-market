<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" type="image/png" href="{{ asset('theme_asset/dash/img/logo.png') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />

    <!-- Your custom CSS -->
    <link rel="stylesheet" href="{{ asset('theme_asset/home/css/home.css') }}" />

    <!-- Title -->
    <title>Profile | Parduotuvė</title>
    @livewireStyles
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <div id="header">
        <div class="container">
            <div class="nav-bar">
                <a href="{{ route('products.browse') }}" class="logo">
                    <img src="{{ asset('theme_asset/dash/img/logo.png') }}" alt="" style="width: 93px; height: 54px;" />
                </a>

                <div class="d-flex align-items-center">
                    <a href="{{ route('cart') }}">
                        <div class="theme-wrap me-3">
                            <div class="theme-icon-wrap">
                                <i class="bi-cart-fill me-1"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="navmenus">
                <div class="nav-links">
                    <a href="{{ route('products.browse') }}">Home</a>
                    <div class="dropdown">
                        <a href="#!" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>

                        @php
                            $categories = App\Models\Category::all();
                        @endphp
                        <ul class="dropdown-menu">
                            @foreach ($categories as $category)
                                <li><a class="dropdown-item" href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @auth
                        <a href="{{ route('cart') }}">Cart</a>
                        <a href="{{ route('logout') }}">Logout</a>
                        <a href="{{ route('profile.edit') }}">Profile</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
                <div class="nav-toggler">
                    <i class="bx bx-menu-alt-right"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="text-center mb-4">
                    <h1 class="fw-bold">Profile Settings</h1>
                    <p class="text-muted">Manage your account information</p>
                </div>

                <!-- Update Profile Info -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="footer" class="mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <a href="#!" class="logo">
                        <img src="{{ asset('theme_asset/dash/img/logo.png') }}" style="width: 175px;" alt="">
                    </a>
                </div>

                <div class="col-lg-3 mb-5">
                    <ul class="footer-list">
                        <h2 class="title">Legals</h2>
                        <li><a href="#!">Contact</a></li>
                        <li><a href="#!">Privacy policy</a></li>
                        <li><a href="#!">Cookie policy</a></li>
                        <li><a href="#!">Terms &amp; Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div class="backdrop-filter"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme_asset/home/js/home.js') }}"></script>
    @livewireScripts
</body>
</html>
