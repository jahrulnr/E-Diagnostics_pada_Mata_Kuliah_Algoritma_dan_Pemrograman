@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<div class="container-fluid px-4">
	<h1 class="my-4">Dashboard</h1>
	
	<div class="row">
	    <div class="col-xl-3 col-md-6">
	        <a href="/mahasiswa/materi" class="card bg-secondary text-white mb-4 pt-2 text-center shadow">
	        	<div class="card-header"><span class="fas fa-book fa-4x"></span></div>
	            <div class="card-body">Materi</div>
	        </a>
	    </div>
	    <div class="col-xl-3 col-md-6">
	        <a href="/mahasiswa/profil" class="card bg-primary text-white mb-4 pt-2 text-center shadow">
	        	<div class="card-header"><span class="fas fa-user fa-4x"></span></div>
	            <div class="card-body">Profil</div>
	        </a>
	    </div>
	    <div class="col-xl-3 col-md-6">
	        <a href="/mahasiswa/hasil_tes" class="card bg-success text-white mb-4 pt-2 text-center shadow">
	        	<div class="card-header"><span class="fas fa-chart-bar fa-4x"></span></div>
	            <div class="card-body">Hasil Tes</div>
	        </a>
	    </div>
	</div>
</div>

@endsection