<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
$user = auth()->user();
        
$availableBooks = \App\Models\Book::inRandomOrder()->take(6)->get();
        $borrowings = collect([]); // Placeholder - Borrowing model belum dibuat
        
        return view('user.dashboard', compact('availableBooks', 'borrowings'));
    }
}
