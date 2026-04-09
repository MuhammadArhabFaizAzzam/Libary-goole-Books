@php
    $darkMode = ($appearance ?? 'system') == 'dark';
@endphp

<!DOCTYPE html>
<html lang="id" class="{{ $darkMode ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Library')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    
    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-pulse">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg animate-pulse">
        {{ session('error') }}
    </div>
    @endif
    
    <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('library.home') }}" class="flex items-center gap-2 group">
                <div class="p-2 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">E-Library</h1>
            </a>
            
            <nav class="flex items-center gap-2 md:gap-4">
                <a href="{{ route('library.books') }}" class="px-3 md:px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    Browse
                </a>
                <a href="{{ route('library.my.books') }}" class="px-3 md:px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    My Books
                </a>
@if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-3 md:px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        Admin
                    </a>
                @endif
                <a href="{{ route('dashboard') }}" class="px-3 md:px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-medium bg-gray-600 text-white hover:bg-gray-700 rounded-lg transition-colors">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="py-8">
        @yield('content')
    </main>
</body>
</html>