<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleBooksService;
use App\Models\Book;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LibraryController extends Controller
{
    protected GoogleBooksService $googleBooks;

    public function __construct(GoogleBooksService $googleBooks)
    {
        $this->middleware('auth');
        $this->googleBooks = $googleBooks;
    }

    public function home(Request $request): View
    {
        $query = $request->get('q', '');
        $books = [];

        if ($query) {
            $volumes = $this->googleBooks->search($query, 12, 'id');
            $books = collect($volumes)->map(fn($item) => $this->googleBooks->formatBook($item['volumeInfo']))
                ->filter(fn($book) => $book['title'] !== 'Unknown Title');
        }

        return view('library.home', compact('books', 'query'));
    }

    public function books(Request $request): View
    {
        $query = $request->get('q');
        $page = $request->get('page', 1);

        if (!$query) {
            return redirect()->route('library.home');
        }

        $volumes = $this->googleBooks->search($query, 20, 'id');
        $books = collect($volumes)->map(fn($item) => $this->googleBooks->formatBook($item['volumeInfo']))
            ->filter(fn($book) => $book['title'] !== 'Unknown Title')
            ->forPage($page, 20)
            ->values();

        return view('library.books', compact('books', 'query'));
    }

    public function show(string $googleId): View
    {
        $volumeInfo = $this->googleBooks->getBook($googleId);
        if (!$volumeInfo) {
            abort(404);
        }

        $bookData = $this->googleBooks->formatBook($volumeInfo);
        $book = Book::findOrCreateFromGoogle($volumeInfo, $this->googleBooks);
$isSaved = Auth::user()->savedBooks()->where('books.google_id', $googleId)->exists();

        return view('library.book-detail', compact('bookData', 'book', 'isSaved'));
    }

    public function save(string $googleId): RedirectResponse
    {
        $volumeInfo = $this->googleBooks->getBook($googleId);
        if (!$volumeInfo) {
            return back()->with('error', 'Buku tidak ditemukan');
        }

        $book = Book::findOrCreateFromGoogle($volumeInfo, $this->googleBooks);
        $user = Auth::user();

if ($user->savedBooks()->where('book_id', $book->id)->exists()) {
            return back()->with('error', 'Buku sudah disimpan');
        }

        $user->savedBooks()->attach($book->id);

        return back()->with('success', 'Buku berhasil disimpan!');
    }

    public function unsave(string $googleId): RedirectResponse
    {
        $book = Book::where('google_id', $googleId)->firstOrFail();
        Auth::user()->savedBooks()->detach($book->id);

        return back()->with('success', 'Buku dihapus dari simpanan');
    }
}

