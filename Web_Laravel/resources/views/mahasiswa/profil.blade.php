@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<!-- Plugin -->
<style>
	/* Toastr */
	@import url('/vendor/toastr/toastr.min.css');
</style>
<!-- Toastr -->
<script src="/vendor/toastr/toastr.min.js"></script>

<div class="container-fluid px-4">
    <h1 class="my-4">Profil</h1>
	<div class="row">
    <form method="POST" class="col-12 col-md-6" action="/mahasiswa/profil/simpan">
    	@csrf
      <div class="form-input mb-3">
      	<label>NPM</label>
      	<input type="text" class="form-control" value="{{ $data->npm }}" readonly>
      </div>
      <div class="form-input mb-3">
      	<label>Nama</label>
      	<input type="text" name="nama_mhs" class="form-control" value="{{ $data->nama_mhs }}" placeholder="Nama" required>
      </div>
      <div class="form-input mb-3">
      	<label>Email</label>
      	<input type="text" name="email" class="form-control" value="{{ $data->email }}" placeholder="user@contoh.com" required>
      </div>
      <div class="form-input mb-3">
      	<label>Dosen Pengampu / Kelas</label>
      	<input class="form-control" value="{{ $data->nama_dsn }} / {{ $data->kelas }}" readonly>
      </div>
      <div class="form-input mb-3">
      	<label for="password">Password Baru <sup>* Optional</sup></label>
      	<input type="password" name="password" class="form-control" placeholder="Password">
      </div>
      <div class="text-end">
      	<button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

@endsection