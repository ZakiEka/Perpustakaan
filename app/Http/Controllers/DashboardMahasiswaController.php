<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DashboardMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request('search')) {
            $mahasiswas = User::where('name', 'like', '%'.request('search').'%')
            ->where('role', '=', 'mahasiswa')
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $mahasiswas = User::latest()->where('role', '=', 'mahasiswa')->get();
        }
        
        return view('dashboard-mahasiswa.index', ['mahasiswas' => $mahasiswas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard-mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'npm' => 'required|numeric|unique:users',
            'email' => 'required|email|unique:users'
        ]);

        $validatedData['password'] = Hash::make($validatedData['npm']);
        $validatedData['role'] = 'Mahasiswa';
        $validatedData['skor'] = 0;

        User::create($validatedData);

        return redirect()->route('dashboard-mahasiswa.index')->with('alert', 'Data berhasil ditambahkan');
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
    public function edit(string $npm)
    {
        $mahasiswa = User::where('npm', $npm)->get();
        
        return view('dashboard-mahasiswa.edit', ['mahasiswa' => $mahasiswa[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $npm)
    {
        $mahasiswa = $this->getMahasiswa($npm);
        $credentials['name'] = 'required|min:3';

        $credentials['npm'] = $mahasiswa['npm'] == $request->npm ? 'required|numeric' : 'required|numeric|unique:users';
        $credentials['email'] = $mahasiswa['email'] == $request->email ? 'required|email' : 'required|email|unique:users';
        
        $validatedData = $request->validate($credentials);
        $mahasiswa['npm'] == $validatedData['npm'] ? '' : $validatedData['password'] = Hash::make($validatedData['npm']);

        $mahasiswa->update($validatedData);

        return redirect()->route('dashboard-mahasiswa.index')->with('alert', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $npm)
    {
        $mahasiswa = $this->getMahasiswa($npm);
        $mahasiswa->delete();

        return redirect()->route('dashboard-mahasiswa.index')->with('alert', 'Data berhasil dihapus');
    }

    public function getMahasiswa($npm) {
        $mahasiswa = User::where('npm', $npm)->get();
        return $mahasiswa[0];
    }
}
