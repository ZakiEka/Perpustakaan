@extends('layouts.dashboard')
@section('main')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Halaman</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Mahasiswa</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Mahasiswa</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here...">
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
              <h6>Tambah Data Mahasiswa</h6>
            </div>
            <div class="card-body pt-0 pb-0">
                <form action="{{ route('dashboard-mahasiswa.update', $mahasiswa->npm) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name" class="form-control-label">Nama</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" value="{{ old('name', $mahasiswa->name) }}" name="name">
                        @error('name') <small class="invalid-feedback">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="npm" class="form-control-label">Npm</label>
                        <input class="form-control @error('npm') is-invalid @enderror" type="number" id="npm" value="{{ old('npm', $mahasiswa->npm) }}" name="npm">
                        @error('npm') <small class="invalid-feedback">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-control-label">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" value="{{ old('email', $mahasiswa->email) }}" name="email">
                        @error('email') <small class="invalid-feedback">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                        <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection