@extends('layouts.library')

@section('title', 'Cari Buku | E-Library')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumb --}}
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('library.home') }}" class="hover:text-gray-700">Beranda</a>
            </li>
            <li>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </li>
            <li class="font-medium text-gray-900 dark:text-white">Hasil Pencarian</li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Hasil untuk "{{ request('q') }}"</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ count($books) }} buku ditemukan</p>
        </div>
        <a href="{{ route('library.home') }}" class="mt-4 md:mt-0 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl hover:shadow-md transition-all text-gray-900 dark:text-white">
            ← Kembali ke Beranda
        </a>
    </div>

    @if(count($books) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($books as $book)
        <article class="group bg-white dark:bg-gray-800 rounded-3xl shadow-xl hover:shadow-2xl transition-all border border-gray-100 dark:border-gray-700 overflow-hidden">
            @if(isset($book['google_id']) && $book['google_id'])
            <a href="{{ route('library.book.detail', $book['google_id']) }}" class="block">
            @else
            <div class="block">
            @endif
                <div class="aspect-[2/3] relative overflow-hidden">
                    @if(isset($book['thumbnail']) && $book['thumbnail'])
                        <img src="{{ $book['thumbnail'] }}" alt="{{ $book['title'] }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                             loading="lazy"/>
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                </div>
            @if(isset($book['google_id']) && $book['google_id'])
            </a>
            @else
            </div>
            @endif
            
            <div class="p-8">
                @if(isset($book['google_id']) && $book['google_id'])
                <a href="{{ route('library.book.detail', $book['google_id']) }}">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-purple-600 transition-colors">{{ $book['title'] }}</h2>
                </a>
                @else
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">{{ $book['title'] }}</h2>
                @endif
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1">Penulis</p>
                    <p class="text-gray-900 dark:text-white line-clamp-1">
                        @if(isset($book['authors']) && !empty($book['authors']))
                            {{ collect($book['authors'])->take(3)->implode(', ') }}
                            @if(count($book['authors']) > 3)...@endif
                        @else
                            Tidak diketahui
                        @endif
                    </p>
                </div>

                @if(isset($book['publisher']) || isset($book['published_year']))
                <div class="mb-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $book['publisher'] ?? '' }} • {{ $book['published_year'] ?? '' }}</p>
                </div>
                @endif

                @if(isset($book['page_count']) && $book['page_count'])
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ number_format($book['page_count']) }} halaman
                </div>
                @endif

                <div class="flex gap-3">
                    @if(isset($book['google_id']) && $book['google_id'])
                    <a href="{{ route('library.book.detail', $book['google_id']) }}" 
                       class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 px-6 rounded-xl font-bold text-center hover:from-purple-700 hover:to-pink-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Baca Detail
                    </a>
                    @else
                    <button disabled class="flex-1 bg-gray-400 text-white py-4 px-6 rounded-xl font-bold text-center cursor-not-allowed">
                        No Detail
                    </button>
                    @endif
                    @if(isset($book['preview_link']) && $book['preview_link'])
                    <a href="{{ $book['preview_link'] }}" target="_blank" rel="noopener" 
                       class="p-4 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all shadow-md hover:shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </div>

    @else
    <div class="text-center py-24">
        <svg class="mx-auto h-24 w-24 text-gray-400 mb-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Buku tidak ditemukan</h3>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Coba kata kunci lain atau periksa ejaan.
        </p>
        <a href="{{ route('library.home') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition-all shadow-lg">
            ← Cari Buku Lain
        </a>
    </div>
    @endif
</div>
@endsection

