<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="{{ asset('icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
</head>
<body>
    @include('components.navbar')
    
    <div>
        @include('components.sidebar')
        
        <div class="main-content">
            <div class="main-wrapper">
                @yield('content')
            </div>
            @include('components.footer')
        </div>
    </div>
    

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <!-- Independent CSS -->
    @stack('styles')
    
    <!-- Independent JS -->
     @stack('scripts')
</body>
</html>