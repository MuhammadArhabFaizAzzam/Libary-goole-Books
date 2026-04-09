<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoogleBooksService
{
    private string $apiKey = 'AIzaSyCGbxi_PS8bKP1xxvkzWZdLJKVFRY5bdd4';
    private string $baseUrl = 'https://www.googleapis.com/books/v1';

    /**
     * Search books by query
     */
    public function search(string $query, int $maxResults = 40, string $lang = 'id'): array
    {
        $cacheKey = "google_books_search_{md5($query)}_{$maxResults}_{$lang}";
        
        return Cache::remember($cacheKey, 3600, function () use ($query, $maxResults, $lang) {
            $response = Http::get("{$this->baseUrl}/volumes", [
                'q' => $query,
                'maxResults' => $maxResults,
                'langRestrict' => $lang,
                'key' => $this->apiKey,
                'projection' => 'full',
                'orderBy' => 'relevance',
            ]);

            if ($response->successful()) {
                return $response->json('items', []);
            }

            Log::error('Google Books API error: ' . $response->body());
            return [];
        });
    }

    /**
     * Get book detail by ID
     */
    public function getBook(string $bookId): ?array
    {
        $cacheKey = "google_books_{$bookId}";

        return Cache::remember($cacheKey, 3600, function () use ($bookId) {
            $response = Http::get("{$this->baseUrl}/volumes/{$bookId}", [
                'key' => $this->apiKey,
                'projection' => 'full',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Google Books detail error: ' . $response->body());
            return null;
        });
    }

    /**
     * Format book data for model
     */
    public function formatBook(array $item): array
    {
        $volumeInfo = $item['volumeInfo'] ?? $item;
        $id = $item['id'] ?? $volumeInfo['id'] ?? null;

        $publishedYear = null;
        if (isset($volumeInfo['publishedDate'])) {
            // Ambil tahun dari publishedDate (misal '2020-01-01' -> 2020)
            $publishedYear = (int) substr($volumeInfo['publishedDate'], 0, 4);
        }

        $isbn13 = null;
        if (isset($volumeInfo['industryIdentifiers'])) {
            foreach ($volumeInfo['industryIdentifiers'] as $identifier) {
                if (($identifier['type'] ?? '') === 'ISBN_13') {
                    $isbn13 = $identifier['identifier'] ?? null;
                    break;
                }
            }
        }

        return [
            'google_id' => $id,
            'title' => $volumeInfo['title'] ?? 'Unknown Title',
            'authors' => $volumeInfo['authors'] ?? [],
            'description' => $volumeInfo['description'] ?? null,
            'thumbnail' => $this->getThumbnailUrl($volumeInfo),
            'page_count' => $volumeInfo['pageCount'] ?? null,
            'isbn_13' => $isbn13,
            'publisher' => $volumeInfo['publisher'] ?? null,
            'published_year' => $publishedYear,
            'preview_link' => $volumeInfo['previewLink'] ?? null,
            'info_link' => $volumeInfo['infoLink'] ?? null,
            'subtitle' => $volumeInfo['subtitle'] ?? null,
        ];
    }

    private function getThumbnailUrl(array $volumeInfo): ?string
    {
        if (isset($volumeInfo['imageLinks']['thumbnail'])) {
            return str_replace('http://books.google.com', 'https://books.google.com', $volumeInfo['imageLinks']['thumbnail']);
        }
        return null;
    }
}

