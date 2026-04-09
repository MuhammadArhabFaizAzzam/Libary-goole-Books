@extends('layouts.library')

@section('title', 'Detail Buku | E-Library')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumb --}}
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('library.home') }}" class="hover:text-gray-700">Beranda</a></li>
            <li><svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li><span class="font-medium text-gray-900 dark:text-white">Detail Buku</span></li>
        </ol>
    </nav>

    {{-- Search Books Form --}}
    <div class="mb-12 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-800 rounded-3xl p-8 border border-purple-200 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Cari Buku Lain</h3>
        <form method="GET" action="{{ route('library.books') }}" class="flex gap-3">
            <input 
                type="search" 
                name="q" 
                placeholder="Ketik judul atau penulis buku..." 
                class="flex-1 px-6 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 shadow-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                required
            >
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-2xl hover:from-purple-700 hover:to-pink-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>

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

@if(isset($bookData['subtitle']) && $bookData['subtitle'])
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
                        <button type="button" onclick="showDeleteModal(this)" class="flex items-center gap-3 px-8 py-4 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200 font-bold rounded-2xl hover:bg-green-200 dark:hover:bg-green-800/50 transition-all shadow-lg hover:shadow-xl">
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
@if(isset($bookData['preview_link']) && $bookData['preview_link'])
                <a href="{{ $bookData['preview_link'] }}" target="_blank" rel="noopener" 
                   class="flex items-center justify-center gap-3 px-8 py-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-2xl hover:from-blue-600 hover:to-blue-700 shadow-xl hover:shadow-2xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Baca Preview
                </a>
                @endif

@if(isset($bookData['info_link']) && $bookData['info_link'])
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

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 max-w-sm w-full border border-gray-100 dark:border-gray-700 animate-in fade-in zoom-in duration-300">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto mb-4">
            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white text-center mb-2">Hapus dari Simpanan?</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">Buku ini akan dihapus dari daftar buku tersimpan Anda.</p>
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white font-semibold rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                Batal
            </button>
            <button type="button" id="confirmDeleteBtn" onclick="submitDeleteForm()" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-2xl hover:from-red-600 hover:to-red-700 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
let currentDeleteForm = null;

function showDeleteModal(button) {
    currentDeleteForm = button.closest('form');
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    currentDeleteForm = null;
}

function submitDeleteForm() {
    if (currentDeleteForm) {
        currentDeleteForm.submit();
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    }
});

// Close with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('deleteModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    }
});
</script>

@endsection

