@extends('layouts.dashboard')
@section('main')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Halaman</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Buku</li>
          </ol>
          <h6 class="font-weight-bolder mb-, $book->title0">Buku</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="T, $book->titleype here...">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
           
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-6 mb-4">
          <div class="card">
            <div class="card-header">
              <h6>Tambah Data Buku</h6>
            </div>
            <div class="card-body pt-0 pb-0">
                <form action="{{ route('dashboard-data-buku.update', $book->slug) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="title" class="form-control-label">Judul</label>
                      <input class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                      @error('title') <small class="invalid-feedback">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                      <label for="isbn" class="form-control-label">Isbn</label>
                      <input class="form-control @error('isbn') is-invalid @enderror" type="number" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>
                      @error('isbn') <small class="invalid-feedback">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                      <label for="author" class="form-control-label">Penulis</label>
                      <input class="form-control @error('author') is-invalid @enderror" type="text" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                      @error('author') <small class="invalid-feedback">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                      <label for="publisher" class="form-control-label">Penerbit</label>
                      <input class="form-control @error('publisher') is-invalid @enderror" type="text" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}" required>
                      @error('publisher') <small class="invalid-feedback">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                      <label for="published_at" class="form-control-label">Tanggal Terbit</label>
                      <input class="form-control @error('published_at') is-invalid @enderror" type="date" id="published_at" name="published_at" value="{{ old('published_at', $book->published_at) }}" required>
                      @error('published_at') <small class="invalid-feedback">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                      <label for="page_number" class="form-control-label">Halaman Buku</label>
                      <input class="form-control @error('page_number') is-invalid @enderror" type="number" id="page_number" name="page_number" value="{{ old('page_number', $book->page_number) }}" required>
                      @error('page_number') <small class="invalid-feedback">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                    <label for="stock" class="form-control-label">Stock</label>
                    <input class="form-control @error('stock') is-invalid @enderror" type="number" id="stock" name="stock" value="{{ old('stock', $book->stock) }}" required>
                    @error('stock') <small class="invalid-feedback">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                    <label for="synopsis">Sinopsis Buku</label>
                    <textarea class="form-control @error('synopsis') is-invalid @enderror" id="synopsis" name="synopsis" rows="3" required>{{ old('synopsis', $book->synopsis) }}</textarea>
                    @error('synopsis') <small class="invalid-feedback">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                      <label for="cover" class="form-control-label">Sampul Buku</label>
                      <img src="{{ asset('assets/cover/' . $book->cover . '.webp') }}" class="img-fluid img-preview mb-3 d-block" style="width: 100px;">
                      <input class="form-control @error('cover') is-invalid @enderror" type="file" id="cover" name="cover" onchange="previewImage()">
                      @error('cover') <small class="invalid-feedback">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                      <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <script>
    function previewImage() {
      let image = document.querySelector('#cover')
      let imagePreview = document.querySelector('.img-preview')

      imagePreview.style.display = 'block';

      let oFReader = new FileReader()
      oFReader.readAsDataURL(image.files[0])

      oFReader.onload = function (oFREvent) {
        imagePreview.src = oFREvent.target.result
      }
    }
  </script>
@endsection