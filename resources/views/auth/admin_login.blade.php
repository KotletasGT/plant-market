<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Admin Login | Ignas Eshop</title>
    
    <link rel="icon" type="image/png" href="{{ asset('theme_asset/dash/img/logo.png') }}" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="{{ asset('theme_asset/home/css/home.css') }}" />

    @livewireStyles
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Header -->
    <div id="header" class="py-3 shadow-sm bg-white">
        <div class="container d-flex justify-content-center">
            <a href="{{ route('products.browse') }}">
                <img src="{{ asset('theme_asset/dash/img/logo.png') }}" alt="Logo" style="width: 93px; height: 54px;">
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container my-5 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg rounded-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center fw-bold mb-4">Admin Login</h2>

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-dark w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </button>
            </form>

            @if(session('error'))
                <div class="alert alert-danger mt-3" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-4 bg-white border-top">
        <div class="container text-center">
            <p class="text-muted mb-0">© {{ date('Y') }} Parduotuvė. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>

