
@extends('layouts.home')
@section('main')
@if(Session::has('alert'))
<script>
  Swal.fire({
  icon: "error",
  title: "Gagal!",
  text: "{{ session('alert') }}",
});
</script>
@endif
<nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="{{ Route('home') }}">Home<br></a></li>
    <li><a href="{{ Route('book.index') }}" class="active">Book</a></li>
  </ul>
  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
@if(auth()->guest()) 
      <a class="btn-getstarted flex-md-shrink-0" href="{{ route('login') }}">Login</a>
      @else
      <a class="btn-getstarted flex-md-shrink-0" href="{{ route('dashboard') }}">Dashboard</a>
      @endif
</div>
</header>

<main class="main">

<!-- Hero Section -->

<div class="container" style="margin-top: 100px;">
  <div class="row">
    <div class="col-lg-2">
      <img src="{{ asset('assets/cover/' . $book->cover . '.webp') }}" alt="" class="img-fluid">
      <form action="{{ Route('book.pinjam') }}" method="POST">
        @csrf
        <button class="btn btn-primary mt-3 w-100 mb-3" type="submit" name="slug" value="{{ $book->slug }}">Pinjam buku</button>
      </form>
    </div>
    <div class="col-lg-6">
      <div class="card mb-5">
        <div class="card-body">
          <h5 class="card-title">{{ $book->title }}</h5>
          <table>
            <tr>
              <td>Stok</td>
              <td> : </td>
              <td>{{ $book->stock }}</td>
            </tr>
            <tr>
              <td>Penulis</td>
              <td> : </td>
              <td>{{ $book->author }}</td>
            </tr>
            <tr>
              <td>Penerbit</td>
              <td> : </td>
              <td>{{ $book->publisher }}</td>
            </tr>
            <tr>
              <td>Tahun Terbit</td>
              <td> : </td>
              <td>{{ $book->published_at }}</td>
            </tr>
            <tr>
              <td>Jumlah Halaman</td>
              <td> : </td>
              <td>{{ $book->page_number }}</td>
            </tr>
            <tr>
              <td>Sinopsis</td>
              <td> : </td>
              <td></td>
            </tr>
          </table>
          <small class="card-text d-block">{!! nl2br($book->synopsis) !!}</small>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5>Rekomendasi Buku</h5>
          <div class="row">
            @foreach($books as $bookList)
            <div class="col-3 mb-3">
              <a href="{{ Route('book.detail', $bookList->slug) }}">
                <img src="{{ asset('assets/cover/' . $bookList->cover . '.webp') }}" alt="" style="aspect-ratio: 5/8; object-fit: cover; width: 100%;">
              </a>
            </div>
            <div class="col-9 mb-3">
              <a href="{{ Route('book.detail', $bookList->slug) }}">
                <span class="text-dark">{{ $bookList->title }}</span>
              </a>
            </div>  
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</main>
</div>
@endsection