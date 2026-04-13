<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return inertia('Admin/Dashboard', [
            'stats' => $stats
        ]);
    }
}
