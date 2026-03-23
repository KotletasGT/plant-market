<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Redirect after 10 seconds -->
    <meta http-equiv="refresh" content="10;url={{ route('products.browse') }}" />

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
    <link rel="stylesheet" href="{{asset('theme_asset/home/css/home.css')}}" />

    <!-- Title -->
    <title>Payment Failed | Parduotuvė</title>
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
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="text-center">
            <i class="bi bi-x-circle-fill text-danger" style="font-size: 5rem;"></i>
            <h1 class="mt-4 fw-bold text-danger">Payment Unsuccessful</h1>
            <p class="mt-3 fs-5">You will be redirected to the homepage in 10 seconds...</p>
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

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme_asset/home/js/home.js') }}"></script>
    @livewireScripts
</body>
</html>
