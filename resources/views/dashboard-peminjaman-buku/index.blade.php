@extends('layouts.dashboard')
@section('main')
@if(Session::has('alert'))
<script>
Swal.fire({
  title: "Sukses!",
  text: "{{ session('alert') }}",
  icon: "success"
});
</script>
@endif
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Halaman</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Peminjaman Buku</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Peminjaman Buku</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
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
        <div class="col mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <h6>Data Peminjaman Buku</small></h6>
            </div>
            <div class="card pt-0 pb-3">
                <div class="table-responsive">
                  @if(auth()->user()->role == 'mahasiswa')
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cover</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Judul</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pengambilan</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tangaal Pengembalian</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Verifikasi</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($books as $book)
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div class="my-auto ms-3">
                              <h6 class="mb-0 text-xs">{{ $loop->iteration }}</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <img src="{{ asset('assets/cover/' . $book->cover . '.webp') }}" alt="" height="80px">
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $book->title }}</p>

                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $book->tanggal_pinjam }}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $book->tanggal_kembali }}</p>

                        </td>
              
                        
                        <td class="align-middle">
                          @if($book->status == 'pengambilan')
                          <form action="{{ Route('dashboard-peminjaman-buku.pengambilan') }}" class="d-inline" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" name="id" value="{{ $book->id }}">Buku telah diambil</button>
                          </form>
                          @elseif($book->status == 'dipinjam')
                          <form action="{{ Route('dashboard-peminjaman-buku.pengembalian') }}" class="d-inline" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success" name="id" value="{{ $book->id }}">Kembalikan Buku</button>
                          </form>
                          @else 
                          
                          <p class="text-xs font-weight-bold mb-0">Sudah dikembalikan</p>
                          @endif
                        </td>
                      </tr>                        
                      @endforeach
                    </tbody>
                  </table>
                  @else
                  
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cover</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Judul</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Peminjam</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Npm Peminjam</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pengambilan</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tangaal Pengembalian</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($books as $book)
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div class="my-auto ms-3">
                              <h6 class="mb-0 text-xs">{{ $loop->iteration }}</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <img src="{{ asset('assets/cover/' . $book->cover . '.webp') }}" alt="" height="80px">
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $book->title }}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $book->name }}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $book->npm }}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $book->tanggal_pinjam }}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $book->tanggal_kembali }}</p>

                        </td>
              
                        
                        <td class="align-middle">
                          
                          <p class="text-xs font-weight-bold mb-0">
                            @if($book->status == 'pengambilan')
                              Proses pengambilan buku
                            @elseif($book->status == 'dipinjam')
                              Buku sedang dipinjam
                            @else
                              Buku telah dikembalikan
                            @endif
                          </p>
                       
                        </td>
                      </tr>                        
                      @endforeach
                    </tbody>
                  </table>
                  @endif
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection