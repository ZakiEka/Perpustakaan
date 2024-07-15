@extends('layouts.home')
@section('main')
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
        <h2>List Buku</h2>
        <div class="row">
          @foreach ($books as $book)
          <div class="col-lg-2 col-md-4 col-6 ">
            <a href="{{ Route('book.detail', $book->slug) }}">
              <img src="{{ asset('assets/cover/' . $book->cover . '.webp') }}" alt="" style="aspect-ratio: 5/8; object-fit: cover; width: 100%;">
              <h5 class="mt-3">{{ $book->title }}</h5>
            </a>
        </div>
          @endforeach
          
        </div>
      </div>

  </main>
@endsection