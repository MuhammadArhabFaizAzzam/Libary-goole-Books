@extends('user.dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumb --}}
    <nav class="mb-12">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('library.home') }}" class="hover:text-gray-700">Beranda</a></li>
            <li><svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li><span class="font-medium text-gray-900 dark:text-white">Detail Buku</span></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        {{-- Book Cover --}}
        <div class="lg:sticky lg:top-12 lg:max-h-screen lg:overflow-y-auto">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 border border-gray-100 dark:border-gray-700">
                @if($bookData['thumbnail'])
                    <img src="{{ $bookData['thumbnail'] }}" alt="{{ $bookData['title'] }}" 
                         class="w-full max-w-md mx-auto rounded-2xl shadow-xl object-cover aspect-[2/3]"/>
                @else
                    <div class="w-full max-w-md mx-auto aspect-[2/3] bg-gradient-to-br from-indigo-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-xl">
                        <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        {{-- Book Info --}}
        <div>
            <h1 class="text-3xl lg:text-4xl font-black text-gray-900 dark:text-white mb-6 leading-tight">
                {{ $bookData['title'] }}
            </h1>

            @if($bookData['subtitle'])
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 italic bg-gray-50 dark:bg-gray-900 p-4 rounded-2xl">
                "{{ $bookData['subtitle'] }}"
            </p>
            @endif

            {{-- Authors --}}
            <div class="mb-8">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">Penulis</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($bookData['authors'] ?? [] as $author)
                        <span class="px-4 py-2 bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-200 rounded-full text-sm font-medium">
                            {{ $author }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Meta Info --}}
            <div class="grid grid-cols-2 gap-6 mb-12">
                @if($bookData['published_year'])
                <div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Tahun Terbit</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $bookData['published_year'] }}</p>
                </div>
                @endif

                @if($bookData['page_count'])
                <div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Jumlah Halaman</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($bookData['page_count']) }}</p>
                </div>
                @endif

                @if($bookData['publisher'])
                <div class="col-span-2">
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Penerbit</p>
                    <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $bookData['publisher'] }}</p>
                </div>
                @endif
            </div>

            {{-- Save Button --}}
            <div class="mb-12">
                @if($isSaved)
                    <form method="POST" action="{{ route('library.book.unsave', $bookData['google_id']) }}" class="inline">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-8 py-4 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200 font-bold rounded-2xl hover:bg-green-200 dark:hover:bg-green-800/50 transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Sudah Disimpan ✓
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('library.book.save', $bookData['google_id']) }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-bold rounded-2xl hover:from-emerald-600 hover:to-emerald-700 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Buku Ini
                        </button>
                    </form>
                @endif
            </div>

            {{-- Description --}}
            @if($bookData['description'])
            <div class="mb-12">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-6">Sinopsis</p>
                <div class="prose prose-lg dark:prose-invert max-w-none bg-gray-50 dark:bg-gray-900/50 p-8 rounded-3xl">
                    {!! nl2br(e($bookData['description'])) !!}
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-8 border-t border-gray-200 dark:border-gray-700">
                @if($bookData['preview_link'])
                <a href="{{ $bookData['preview_link'] }}" target="_blank" rel="noopener" 
                   class="flex items-center justify-center gap-3 px-8 py-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-2xl hover:from-blue-600 hover:to-blue-700 shadow-xl hover:shadow-2xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Baca Preview
                </a>
                @endif

                @if($bookData['info_link'])
                <a href="{{ $bookData['info_link'] }}" target="_blank" rel="noopener" 
                   class="flex items-center justify-center gap-3 px-8 py-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold rounded-2xl hover:from-indigo-600 hover:to-purple-700 shadow-xl hover:shadow-2xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Info Lengkap
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

