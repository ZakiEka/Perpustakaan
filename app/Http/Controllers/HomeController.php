<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Pinjam;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index() {
        return view('home.index');
    }

    public function book() {
        if(request('search')) { 

        } else {
            $books = Book::latest()->where('stock', '!=', 0)->get();
        }
        return view('home.book', ['books' => $books]);
    }

    public function bookDetail(Book $book) {
        $books = Book::latest()->where('slug', '!=', $book->slug)->get();
        return view('home.book-detail', compact('book', 'books'));
    }

    public function borrowBook(Request $request) {
        if(auth()->guest()) {
            return redirect()->route('login');
        } else if(auth()->user()->role == 'admin') {
            return redirect()->back()->with('alert', 'Admin tidak dapat meminjam buku');
        }

        $book = $this->getBuku($request->slug);
        $book->stock = $book->stock - 1;
        $book->save();

        Pinjam::create([
            'user_id' => auth()->user()->id,
            'book_id' => $book->id,
            'status' => 'pengambilan',
            'tanggal_pinjam' => Carbon::now()->addDay()->toDateString(),
            'tanggal_kembali' => Carbon::now()->addDay(8)->toDateString()
        ]);

        return redirect()->route('dashboard-peminjaman-buku.index')->with('alert', 'Silahkan ambil buku ke petugas perpustakaan sesuai jadwal pengambilan');
    }

    public function getBuku($slug) {
        $book = Book::where('slug', $slug)->get();
        return $book[0];
    }
}
