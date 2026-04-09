<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleBooksService;
use App\Models\Book;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
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
            $books = collect($volumes)->map(fn($item) => $this->googleBooks->formatBook($item))
                ->filter(fn($book) => $book['title'] !== 'Unknown Title');
        }

        return view('library.home', compact('books', 'query'));
    }

    public function books(Request $request): View
    {
        $query = $request->get('q');
        $page = $request->get('page', 1);

        if (!$query) {
            return view('library.books', ['books' => [], 'query' => '']);
        }

        $volumes = $this->googleBooks->search($query, 20, 'id');
        $books = collect($volumes)->map(fn($item) => $this->googleBooks->formatBook($item))
            ->filter(fn($book) => $book['title'] !== 'Unknown Title')
            ->forPage($page, 20)
            ->values();

        return view('library.books', compact('books', 'query'));
    }

    public function show(string $googleId): View
    {
        $volume = $this->googleBooks->getBook($googleId);
        if (!$volume) {
            abort(404);
        }

        $bookData = $this->googleBooks->formatBook($volume);
        $book = Book::findOrCreateFromGoogle($volume, $this->googleBooks);
$isSaved = DB::table('book_user_saves')->where('user_id', Auth::id())->whereExists(function ($query) use ($googleId) {
            $query->select(DB::raw(1))
                  ->from('books')
                  ->whereColumn('book_user_saves.book_id', 'books.id')
                  ->where('books.google_id', $googleId);
        })->exists();

        return view('library.book-detail', compact('bookData', 'book', 'isSaved'));
    }

    public function save(string $googleId): RedirectResponse
    {
        $volume = $this->googleBooks->getBook($googleId);
        if (!$volume) {
            return back()->with('error', 'Buku tidak ditemukan');
        }

        $book = Book::findOrCreateFromGoogle($volume, $this->googleBooks);
        $user = Auth::user();

if (DB::table('book_user_saves')->where('user_id', $user->id)->where('book_id', $book->id)->exists()) {
            return back()->with('error', 'Buku sudah disimpan');
        }

DB::table('book_user_saves')->insert(['user_id' => $user->id, 'book_id' => $book->id]);

        return back()->with('success', 'Buku berhasil disimpan!');
    }

    public function myBooks(): View
    {
        $user = Auth::user();
$savedBooksIds = DB::table('book_user_saves')->where('user_id', $user->id)->pluck('book_id');
$savedBooks = Book::whereIn('id', $savedBooksIds)->get();
$books = $savedBooks->map(function ($book) {
    $volumeInfo = $this->googleBooks->getBook($book->google_id);
    if (!$volumeInfo) {
        return (array) $book;
    }
    $formatted = $this->googleBooks->formatBook($volumeInfo);
    return array_merge($book->toArray(), $formatted);
});


        return view('library.my-books', compact('books'));
    }

    public function unsave(string $googleId): RedirectResponse
    {
        $book = Book::where('google_id', $googleId)->firstOrFail();
DB::table('book_user_saves')->where('user_id', Auth::id())->where('book_id', $book->id)->delete();

        return back()->with('success', 'Buku dihapus dari simpanan');
    }
}

