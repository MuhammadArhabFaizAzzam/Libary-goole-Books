@extends('user.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Header --}}
    <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4">
            Cari Buku Favoritmu
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-8">
            Jelajahi jutaan buku dari Google Books API
        </p>
        
        {{-- Search Form --}}
        <form method="GET" action="{{ route('library.books') }}" class="max-w-2xl mx-auto">
            <div class="flex gap-3">
                <input 
                    type="search" 
                    name="q" 
                    value="{{ $query ?? '' }}"
                    placeholder="Ketik judul atau penulis buku..." 
                    class="flex-1 px-6 py-4 text-lg border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 shadow-lg bg-white/80 dark:bg-gray-800/80 backdrop-blur"
                    required
                >
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-2xl hover:from-purple-700 hover:to-pink-700 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
            </div>
        </form>
    </div>

    @if($books->count() > 0)
    {{-- Recent Search Results --}}
    <section class="mb-20">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Hasil Pencarian</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($books as $book)
            <div class="group">
                <a href="{{ route('library.book.detail', $book['google_id']) }}" class="block">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all group-hover:-translate-y-2 h-full border-2 border-gray-100 dark:border-gray-700 group-hover:border-purple-300">
                        <div class="aspect-[2/3] relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
                            @if($book['thumbnail'])
                                <img src="{{ $book['thumbnail'] }}" alt="{{ $book['title'] }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                     loading="lazy"/>
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-400 to-pink-500">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-sm line-clamp-2 text-gray-900 dark:text-white mb-2 group-hover:text-purple-600">{{ Str::limit($book['title'], 40) }}</h3>
                            <p class="text-xs text-gray-500 line-clamp-1">
                                @if(!empty($book['authors']))
                                    {{ collect($book['authors'])->take(2)->implode(', ') }}
                                    @if(count($book['authors']) > 2)...@endif
                                @else
                                    Penulis Tidak Diketahui
                                @endif
                            </p>
                            @if($book['page_count'])
                                <p class="text-xs text-gray-400 mt-1">{{ number_format($book['page_count']) }} halaman</p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Popular Categories --}}
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-20">
        <a href="{{ route('library.books', ['q' => 'novel']) }}" class="group p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl hover:from-blue-600 hover:to-blue-700 shadow-xl hover:shadow-2xl transition-all">
            <svg class="w-12 h-12 mx-auto mb-4 opacity-75 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <h3 class="font-bold text-lg mb-1">Novel</h3>
            <p class="text-blue-100 text-sm">Fiksi</p>
        </a>
        <a href="{{ route('library.books', ['q' => 'self help']) }}" class="group p-6 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl hover:from-green-600 hover:to-green-700 shadow-xl hover:shadow-2xl transition-all">
            <svg class="w-12 h-12 mx-auto mb-4 opacity-75 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
            <h3 class="font-bold text-lg mb-1">Self Help</h3>
            <p class="text-green-100 text-sm">Motivasi</p>
        </a>
        <a href="{{ route('library.books', ['q' => 'bisnis']) }}" class="group p-6 bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-2xl hover:from-orange-600 hover:to-orange-700 shadow-xl hover:shadow-2xl transition-all">
            <svg class="w-12 h-12 mx-auto mb-4 opacity-75 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="font-bold text-lg mb-1">Bisnis</h3>
            <p class="text-orange-100 text-sm">Ekonomi</p>
        </a>
        <a href="{{ route('library.books', ['q' => 'teknologi']) }}" class="group p-6 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl hover:from-purple-600 hover:to-purple-700 shadow-xl hover:shadow-2xl transition-all">
            <svg class="w-12 h-12 mx-auto mb-4 opacity-75 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h3 class="font-bold text-lg mb-1">Teknologi</h3>
            <p class="text-purple-100 text-sm">IT & Gadget</p>
        </a>
    </section>
</div>
@endsection

