@extends('layouts.dashboard')
@section('main')
@if(Session::has('alert'))
<script>
Swal.fire({
  title: "Sukses!",
  text: "{{ session('alert') }}",
  icon: "success"
});

setTimeout(() => {
  Swal.close()
}, 2000);
</script>
@endif
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Halaman</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Buku</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Buku</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <form action="">
              <div class="input-group">
                <span class="input-group-text text-body"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control ps-2" placeholder="Type here..." name="search" value="{{ request('search') }}">
              </div>
            </form>
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
              <h6>Data Buku | <small><a href="{{ route('dashboard-data-buku.create') }}">Tambah data</a></small></h6>
            </div>
            <div class="card pt-0 pb-3">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cover</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Judul</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Isbn</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Opsi</th>
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
                          <p class="text-xs font-weight-bold mb-0">{{ $book->isbn }}</p>
                        </td>
              
                        
                        <td class="align-middle">
                          <a href="{{ Route('dashboard-data-buku.edit', $book->slug) }}" class="text-secondary font-weight-bold text-xs">
                            Edit
                          </a>
                          <form action="{{ Route('dashboard-data-buku.destroy', $book->slug) }}" class="d-inline" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ms-3 text-secondary font-weight-bold text-xs" style="background-color: inherit; border: 0px solid black;">Hapus</button>
                          </form>
                        </td>
                      </tr>                        
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection