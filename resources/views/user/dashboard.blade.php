@php
    $darkMode = ($appearance ?? 'system') == 'dark';
@endphp

<!DOCTYPE html>
<html lang="id" class="{{ $darkMode ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E-Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])
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
                <a href="{{ route('library.my-books') }}" class="px-3 md:px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    My Books
                </a>
@if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-3 md:px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        Admin
                    </a>
                @endif
                <a href="{{ route('library.home') }}" class="px-3 md:px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    Library
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
        <div class="max-w-7xl mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4">
                    Selamat Datang,<br>
                    <span class="text-purple-600">{{ Auth::user()->name }}</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Jelajahi koleksi buku kami dan pinjam buku favoritmu
                </p>
            </div>

            <!-- Available Books Section -->
            <section class="mb-16">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Buku Tersedia</h2>
                        <a href="{{ route('library.books') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                            Lihat Semua →
                        </a>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($availableBooks as $book)
                            <div class="group">
                                <a href="{{ route('library.book.detail', ['id' => $book->mangadex_id ?? $book->id]) }}" class="block">
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all group-hover:-translate-y-1 h-full">
                                        <div class="aspect-[2/3] relative bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-800 dark:to-gray-700 overflow-hidden">
                                            @if($book->cover_url)
                                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" loading="lazy"/>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-400 to-pink-500">
                                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-3">
                                            <h3 class="font-semibold text-sm line-clamp-2 text-gray-900 dark:text-white mb-1">{{ $book->title }}</h3>
                                            <p class="text-xs text-gray-500">{{ $book->author }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Borrowing History -->
            <section class="mb-16">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Riwayat Peminjaman</h2>
                    @if($borrowings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Pinjam</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Batas Waktu</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach($borrowings as $borrowing)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-9">
                                                    @if($borrowing->book->cover_url)
                                                        <img class="h-12 w-9 rounded-lg object-cover" src="{{ $borrowing->book->cover_url }}" alt="">
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $borrowing->book->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ $borrowing->book->author }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                            {{ $borrowing->borrow_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $borrowing->due_date->isPast() ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                                                {{ $borrowing->due_date->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $borrowing->status == 'returned' ? 'green' : 'blue' }}-100 text-{{ $borrowing->status == 'returned' ? 'green' : 'blue' }}-800 dark:bg-{{ $borrowing->status == 'returned' ? 'green' : 'blue' }}-900/30 dark:text-{{ $borrowing->status == 'returned' ? 'green' : 'blue' }}-400">
                                                {{ ucfirst($borrowing->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($borrowing->status == 'borrowed')
                                                <form action="{{ route('library.return', $borrowing->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">Kembalikan</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada riwayat peminjaman</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pinjam buku pertama kamu sekarang</p>
                            <div class="mt-6">
                                <a href="{{ route('library.books') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                                    Pinjam Buku
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold">{{ $availableBooks->count() }}</h3>
                            <p class="text-blue-100">Buku Tersedia</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c.656 0 1.283.126 1.857.356m0 0a5.002 5.002 0 019.286 0M15 7a6 6 0 11-12 0 6 6 0 0112 0zm6 3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold">{{ $borrowings->count() }}</h3>
                            <p class="text-green-100">Riwayat Pinjam</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.5h3m1.5 1.5H6a2 2 0 01-2-2V7a2 2 0 012-2h11.5a2 2 0 012 2v4"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold">Baca Sekarang</h3>
                            <p class="text-purple-100">Buku favoritmu</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <a href="{{ route('library.books') }}" class="px-8 py-4 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-all shadow-lg">
                    Jelajahi Koleksi
                </a>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 py-12 mt-24">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm">© {{ date('Y') }} E-Library. Dibuat untuk pecinta manga.</p>
        </div>
    </footer>

</body>
</html>
