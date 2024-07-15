<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Pinjam;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard.index', [
            'totalBuku' => Book::count(),
            'totalMahasiswa' => User::where('role', '!=', 'admin')->count(),
            'totalDipinjam' => Pinjam::where('status', '!=', 'dikembalikan')->count(),
            'totalStok' => Book::sum('stock'),
        ]);
    }
}
