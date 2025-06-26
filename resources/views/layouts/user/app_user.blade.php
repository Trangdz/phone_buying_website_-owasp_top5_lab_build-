<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VNCS Global') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'VNCS Global') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item d-flex align-items-center">
                                <a class="nav-link position-relative me-2" href="{{route('user.index')}}">
                                    Home
                                 </a>
                                {{-- Giỏ hàng --}}
                                <a class="nav-link position-relative me-2" href="{{route('user.cart')}}">
                                    🛒Shopping cart
                                    @if(session('cart') && count(session('cart')) > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count(session('cart')) }}
                                        </span>
                                    @endif
                                </a>
                                <a class="nav-link position-relative me-2" href="{{route('user.history')}}">
                                    History
                                    {{-- @if(session('cart') && count(session('cart')) > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count(session('cart')) }}
                                        </span>
                                    @endif --}}
                                </a>
                                
                                {{-- Tên người dùng & menu --}}
                                <div class="dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('admin.auth.profile') }}">
                                            Profile
                                        </a>
                                        {{-- <a class="dropdown-item" href="{{ route('admin.auth.change-password') }}">
                                            Change Password
                                        </a> --}}
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Log out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4 flex-fill">
            @yield('content')
        </main>
        {{-- Main content with sidebar --}}
        {{-- <div class="d-flex">
            @include('layouts.sidebar')
            <main class="py-4 flex-fill">
                @yield('content')
            </main>
        </div> --}}
    </div>
</body>
{{-- <script>
    function trackSearch(query) {
        document.write('<img src="/resources/images/tracker.gif?searchTerms='+query+'">');
    }
    var query = (new URLSearchParams(window.location.search)).get('search');
    if(query) {
        trackSearch(query);
    }
</script> --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const query = (new URLSearchParams(window.location.search)).get('search');

        if (query) {
            const hasComments = document.querySelector('.comments-list');
            if (!hasComments) {
                const warning = document.createElement('div');
                warning.className = 'alert alert-warning mt-4 text-center';
                warning.textContent = '<img src="../../../image/nothingi.jpg?searchTerms=' + query + '">';

                const container = document.querySelector('.card-body');
                if (container) {
                    container.appendChild(warning);
                }
                // document.write('<img src="../../../image/nothingi.jpg?searchTerms=' + encodeURIComponent(query) + '">');
                
            }
        }
    });
</script> --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const query = new URLSearchParams(window.location.search).get('search');
        const commentsExist = document.querySelector('.comments-list');
    
        if (query && !commentsExist) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-warning text-center mt-4';
            alertDiv.innerHTML = `
                <img src="/storage/asset/nothingi.jpg?searchTerms=${(query)}"
                     alt="Không tìm thấy kết quả ${(query)}" style="max-width:300px;" class="img-fluid my-3">    
            `;
    
            document.querySelector('.card-body')?.appendChild(alertDiv);
        }
    });
    </script>
    


</html>
