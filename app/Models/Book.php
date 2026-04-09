<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\GoogleBooksService;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_id',
        'title',
        'authors',
        'description',
        'thumbnail',
        'page_count',
        'isbn_13',
        'publisher',
        'published_year',
    ];

    protected $casts = [
        'authors' => 'array',
        'page_count' => 'integer',
        'published_year' => 'integer',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'book_user_saves');
    }

    public static function findOrCreateFromGoogle($item, GoogleBooksService $service)
    {
        $googleId = $item['id'] ?? $item['volumeInfo']['id'] ?? null;
        if (!$googleId) return null;

        return self::updateOrCreate(
            ['google_id' => $googleId],
            $service->formatBook($item)
        );
    }
}
