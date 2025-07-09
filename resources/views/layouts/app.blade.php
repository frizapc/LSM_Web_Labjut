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
    <style>
        :root {
            --purple-primary: #6a0dad;
            --purple-secondary: #9c27b0;
            --purple-light: #ba68c8;
            --purple-dark: #4a148c;
        }
        
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            padding-top: 56px;
        }
        
        .title-purple {
            color: var(--purple-primary) !important;
        }

        .bg-purple {
            background-color: var(--purple-primary) !important;
        }
        
        .sidebar {
            background-color: var(--purple-dark);
            width: 250px;
            min-height: calc(100vh - 56px);
            padding-top: 1rem;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
        }
        
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link.active {
            color: white;
            background-color: var(--purple-secondary);
        }

        .account-set {
            display: none;
        }
        
        .main-content{
            flex: 1;
            margin-left: 250px;
        }
        .main-content > div > div{
            padding: 20px;
        }
        .main-wrapper{
            min-height: calc(100vh - 112px);
            display: flex;
            justify-content: space-around;
        }
        
        .footer {
            background-color: var(--purple-primary);
            color: white;
            padding: 1rem;
        }
        
        /* Tambahkan ini ke CSS custom Anda */
        .course-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(106, 13, 173, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .course-card:hover {
            box-shadow: 0 10px 20px rgba(106, 13, 173, 0.1);
            transform: translateY(-5px);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.03);
        }

        .bg-purple-light {
            background-color: var(--purple-secondary);
        }

        .btn-light-purple {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
        }

        .btn-light-purple:hover {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .alert-purple {
            background-color: rgba(106, 13, 173, 0.1);
            border-color: rgba(106, 13, 173, 0.2);
            color: #6a0dad;
        }

        /* Pagination styling */
        .pagination .page-item.active .page-link {
            background-color: #6a0dad;
            border-color: #6a0dad;
        }
    
        .pagination .page-link {
            color:rgb(8, 8, 8);
        }

        @media (max-width: 992px) {
            .navbar-brand {
                font-size: 1rem;
            }

            .sidebar {
                background-color: var(--purple-dark);
                width: 250px;
                height: calc(100vh - 56px); 
                position: fixed;
                top: 56px;
                left: -250px;
                transition: all 0.3s ease;
                z-index: 1000;
                overflow-y: auto;
            }

            .sidebar.active {
                left: 0;
            }

            .account-set {
                display: block;
            }

            .main-content{
                margin-left: 0px;
            }

            .footer {
                margin-left: 0;
                width: 100%;
                font-size: 0.8rem;
            }
        }
        
    </style>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                console.log('clicked')
                document.querySelector('.sidebar').classList.toggle('active');
            });
        });
    </script>
</body>
</html>