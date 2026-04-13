<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiction',
                'description' => 'Novels, short stories, and other literary works',
            ],
            [
                'name' => 'Non-Fiction',
                'description' => 'Biographies, memoirs, history, and self-help books',
            ],
            [
                'name' => 'Science Fiction',
                'description' => 'Futuristic stories, space opera, and dystopian novels',
            ],
            [
                'name' => 'Romance',
                'description' => 'Love stories and romantic fiction',
            ],
            [
                'name' => 'Mystery & Thriller',
                'description' => 'Crime novels, detective stories, and suspense thrillers',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );
        }
    }
}
