<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Str;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class DashboardDataBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request('search')) {
            $books = Book::where('title', 'like', '%'.request('search').'%')
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $books = Book::latest()->get();
        }
        
        return view('dashboard-data-buku.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard-data-buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'isbn' => 'required|size:13|unique:books',
            'author' => 'required',
            'publisher' => 'required',
            'published_at' => 'required',
            'page_number' => 'required|numeric',
            'stock' => 'required|numeric',
            'synopsis' => 'required'
        ]);

        $validatedData['slug'] = SlugService::createSlug(Book::class, 'slug', $validatedData['title']);
        $coverName = $validatedData['isbn'] . '-' . Str::random(8);
        $coverCompressed = Image::read($request->file('cover'))->scaleDown(width : 1080)->toWebp();
        $coverCompressed->save("assets/cover/$coverName.webp");
        $validatedData['cover'] = $coverName;

        Book::create($validatedData);

        return redirect()->route('dashboard-data-buku.index')->with('alert', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $book = Book::where('slug', $slug)->get();
        
        return view('dashboard-data-buku.edit', ['book' => $book[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $book = $this->getBuku($slug);
        $credentials['title'] = 'required';
        $credentials['author'] = 'required';
        $credentials['publisher'] = 'required';
        $credentials['published_at'] = 'required';
        $credentials['page_number'] = 'required|numeric';
        $credentials['stock'] = 'required|numeric';
        $credentials['synopsis'] = 'required';
        $credentials['isbn'] = $book->isbn == $request->isbn ? 'required|size:13' : 'required|size:13|unique:books';
        $validatedData = $request->validate($credentials);

        if(strtolower($book->title) != strtolower($validatedData['title'])) {
            $validatedData['slug'] = SlugService::createSlug(Book::class, 'slug', $validatedData['title']);
        }

        if($request->file('cover')) {
            $this->deleteCover($book->cover);

            $coverName = $validatedData['isbn'] . '-' . Str::random(8);
            $coverCompressed = Image::read($request->file('cover'))->scaleDown(width : 1080)->toWebp();
            $coverCompressed->save("assets/cover/$coverName.webp");
            $validatedData['cover'] = $coverName;
        }

        $book->update($validatedData);

        return redirect()->route('dashboard-data-buku.index')->with('alert', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $isbn)
    {
        $book = $this->getBuku($isbn);
        $this->deleteCover($book->cover);

        $book->delete();

        return redirect()->route('dashboard-data-buku.index')->with('alert', 'Data berhasil dihapus');
    }

    
    public function getBuku($slug) {
        $book = Book::where('slug', $slug)->get();
        return $book[0];
    }

    public function deleteCover($coverName) {
        $coverPath = public_path("assets/cover/$coverName.webp");
        if (File::exists($coverPath)) {
            File::delete($coverPath);
        }
    }
}
