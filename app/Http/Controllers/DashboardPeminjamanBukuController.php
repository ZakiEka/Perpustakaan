<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjam;
use App\Models\Book;
use PhpParser\Node\Stmt\Return_;

class DashboardPeminjamanBukuController extends Controller
{
    public function index() {
        if(auth()->user()->role == 'mahasiswa') {
            $pinjam = Pinjam::where('user_id', '=', auth()->user()->id)->join('books', 'pinjams.id', '=', 'books.id')->get();
        } else {
        }
        $pinjam = Pinjam::join('books', 'pinjams.id', '=', 'books.id')->join('users', 'pinjams.id', '=', 'users.id')->orderBy('pinjams.created_at', 'desc')->get();
        return view('dashboard-peminjaman-buku.index', [
            'books' => $pinjam
        ]);
    }

    public function pengambilan(Request $request) {
        $pinjam = Pinjam::find($request->id);
        $pinjam->status = 'dipinjam';
        $pinjam->save();
        return redirect()->back()->with('alert', 'Buku telah anda ambil, jangan lupa melakukan pengembalian sesuai jadwal');
    }

    public function pengembalian(Request $request) {
        $pinjam = Pinjam::find($request->id);
        $pinjam->status = 'dikembalikan';
        $book = Book::find($pinjam->book_id);
        $book->stock = $book->stock + 1;
        $book->save();
        $pinjam->save();

        return redirect()->back()->with('alert', 'Buku telah anda kembalikan');
    }
}
