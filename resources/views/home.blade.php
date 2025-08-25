<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Home</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        .carousel-item {
            height: 500px;
        }
        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            padding: 20px;
            bottom: 30px;
        }
        .carousel-caption h5 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .carousel-caption p {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        .btn-slide {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            padding: 12px 30px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn-slide:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        @media (max-width: 768px) {
            .carousel-item {
                height: 300px;
            }
            .carousel-caption h5 {
                font-size: 1.5rem;
            }
            .carousel-caption p {
                font-size: 1rem;
            }
            .carousel-caption {
                bottom: 10px;
                left: 10px;
                right: 10px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.featured') }}">Featured Pages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Slider -->
    @if($slides->count() > 0)
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                @foreach($slides as $index => $slide)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" 
                            class="{{ $index === 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                @foreach($slides as $index => $slide)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ $slide->image_url }}" alt="{{ $slide->image_alt ?: $slide->name }}">
                        <div class="carousel-caption d-md-block">
                            <h5>{{ $slide->name }}</h5>
                            @if($slide->description)
                                <p>{{ $slide->description }}</p>
                            @endif
                            @if($slide->link_url && $slide->link_text)
                                <a href="{{ $slide->link_url }}" target="{{ $slide->link_target }}" 
                                   class="btn btn-primary btn-slide">
                                    {{ $slide->link_text }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @endif

    <!-- Main Content -->
    <main class="container my-5">
        @if($slides->count() === 0)
            <!-- No Slides Message -->
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <h1 class="display-4">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                        <p class="lead">No slides available at the moment.</p>
                        @auth
                            <a href="{{ route('admin.slides.create') }}" class="btn btn-primary">
                                Create First Slide
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @else
            <!-- Welcome Section -->
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <h1 class="display-4">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                        <p class="lead">Discover amazing content and explore our featured pages.</p>
                        <a href="{{ route('pages.featured') }}" class="btn btn-outline-primary btn-lg">
                            View Featured Pages
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Features Section -->
        <div class="row mt-5">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-speedometer2 display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Fast & Reliable</h5>
                        <p class="card-text">Built with Laravel for optimal performance and reliability.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-phone display-4 text-success mb-3"></i>
                        <h5 class="card-title">Mobile Responsive</h5>
                        <p class="card-text">Fully responsive design that works perfectly on all devices.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check display-4 text-warning mb-3"></i>
                        <h5 class="card-title">Secure</h5>
                        <p class="card-text">Built with security best practices and modern frameworks.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ config('app.name', 'Laravel') }}</h5>
                    <p>A modern web application built with Laravel and Bootstrap.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</body>
</html>
