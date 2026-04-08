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
                $volume = $response->json();
                return $volume['volumeInfo'] ?? null;
            }

            Log::error('Google Books detail error: ' . $response->body());
            return null;
        });
    }

    /**
     * Format book data for model
     */
    public function formatBook(array $volumeInfo): array
    {
        return [
            'google_id' => $volumeInfo['id'] ?? null,
            'title' => $volumeInfo['title'] ?? 'Unknown Title',
            'subtitle' => $volumeInfo['subtitle'] ?? null,
            'authors' => $volumeInfo['authors'] ?? [],
            'description' => $volumeInfo['description'] ?? null,
            'page_count' => $volumeInfo['pageCount'] ?? null,
            'published_date' => $volumeInfo['publishedDate'] ?? null,
            'publisher' => $volumeInfo['publisher'] ?? null,
            'thumbnail' => $this->getThumbnailUrl($volumeInfo),
            'preview_link' => $volumeInfo['previewLink'] ?? null,
            'info_link' => $volumeInfo['infoLink'] ?? null,
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

