@extends('layouts.library')

@section('title', 'Buku Saya | E-Library')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumb --}}
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('library.home') }}" class="hover:text-gray-700">Beranda</a></li>
            <li><svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="font-medium text-gray-900 dark:text-white">Buku Saya</li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Buku yang Disimpan</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ count($books) }} buku disimpan</p>
        </div>
        <a href="{{ route('library.home') }}" class="mt-4 md:mt-0 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl hover:shadow-md transition-all text-gray-900 dark:text-white">
            ← Kembali ke Library
        </a>
    </div>

    @if(count($books) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($books as $book)
        <article class="group bg-white dark:bg-gray-800 rounded-3xl shadow-xl hover:shadow-2xl transition-all border border-gray-100 dark:border-gray-700 overflow-hidden">
            <a href="{{ route('library.book.detail', $book['google_id']) }}" class="block">
                <div class="aspect-[2/3] relative overflow-hidden">
                    @if($book['thumbnail'])
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
            </a>
            
            <div class="p-8">
                <div class="flex items-start justify-between mb-4">
                    <a href="{{ route('library.book.detail', $book['google_id']) }}">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white line-clamp-2 group-hover:text-purple-600 transition-colors">{{ $book['title'] }}</h2>
                    </a>
                    <form method="POST" action="{{ route('library.book.unsave', $book['google_id']) }}" class="ml-4">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="text-red-500 hover:text-red-700 font-medium text-sm p-1 -m-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="showDeleteModal(this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1">Penulis</p>
                    <p class="text-gray-900 dark:text-white line-clamp-1">
                        @if(!empty($book['authors']))
                            {{ collect($book['authors'])->take(3)->implode(', ') }}
                            @if(count($book['authors']) > 3)...@endif
                        @else
                            Tidak diketahui
                        @endif
                    </p>
                </div>

                @if($book['page_count'])
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ number_format($book['page_count']) }} halaman
                </div>
                @endif

                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('library.book.detail', $book['google_id']) }}" 
                       class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-6 rounded-xl font-bold text-center hover:from-purple-700 hover:to-pink-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    @else
    <div class="text-center py-24">
        <svg class="mx-auto h-24 w-24 text-gray-400 mb-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M9 5l7 7-7 7"/>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Belum ada buku tersimpan</h3>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Cari dan simpan buku favoritmu dari library.
        </p>
        <a href="{{ route('library.home') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition-all shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Cari Buku
        </a>
    </div>
    @endif
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
    modal.style.animation = 'fadeIn 0.3s ease-in';
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
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
});

// Close with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
        closeDeleteModal();
    }
});
</script>

@endsection

