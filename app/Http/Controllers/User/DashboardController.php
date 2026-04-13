<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $savedBooksCount = $user->savedBooks()->count();

        return Inertia::render('Dashboard', [
            'savedBooksCount' => $savedBooksCount,
        ]);
    }
}

