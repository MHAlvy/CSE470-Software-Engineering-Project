<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CrowdAid - Community Donation Platform</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 text-gray-900 font-sans">
    
    <div class="min-h-screen flex flex-col justify-center items-center relative overflow-hidden bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/crowdaid_hero_bg.jpg') }}');">
        @if (Route::has('login'))
            <div class="absolute top-0 right-0 p-6 text-right z-20">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-white hover:text-indigo-200 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-white hover:text-indigo-200 transition">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-6 font-semibold text-blue-900 bg-white px-5 py-2 rounded-full hover:bg-gray-100 transition shadow-md">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="text-center z-10 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
            
            <h1 class="text-6xl md:text-8xl font-extrabold text-white tracking-tight mb-6 drop-shadow-lg">
                CrowdAid
            </h1>
            
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-6 md:p-8 rounded-2xl shadow-2xl mb-10">
                <p class="text-2xl md:text-3xl text-white font-semibold mb-4 drop-shadow-md">
                    "For the people. By the people. Of the people."
                </p>
                <p class="text-lg md:text-xl text-blue-100 font-light max-w-2xl mx-auto">
                    A community-driven platform connecting donors, receivers, and volunteer drivers. We make mutual aid simple, secure, and transparent.
                </p>
            </div>
            
            @guest
                <div class="flex flex-col sm:flex-row justify-center gap-4 mt-4">
                    <a href="{{ route('register') }}" class="bg-white text-indigo-900 font-bold text-lg py-3 px-8 rounded-full shadow-xl hover:bg-gray-100 transition transform hover:-translate-y-1">
                        Join the Community
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white font-bold text-lg py-3 px-8 rounded-full shadow-xl hover:bg-white hover:text-indigo-900 transition transform hover:-translate-y-1">
                        Sign In
                    </a>
                </div>
            @endguest
            
            @auth
                <div class="flex justify-center mt-4">
                    <a href="{{ url('/dashboard') }}" class="bg-white text-indigo-900 font-bold text-lg py-3 px-8 rounded-full shadow-xl hover:bg-gray-100 transition transform hover:-translate-y-1">
                        Enter Dashboard →
                    </a>
                </div>
            @endauth
        </div>
        
        </div>
    
</body>
</html>