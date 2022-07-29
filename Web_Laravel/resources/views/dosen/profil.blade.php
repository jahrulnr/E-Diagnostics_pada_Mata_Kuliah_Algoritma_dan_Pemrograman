@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')


<!-- Toastr -->
<script src="/vendor/toastr/toastr.min.js"></script>
<style>
	@import url('/vendor/toastr/toastr.min.css');
</style>

<div class="container-fluid px-4">
	<h1 class="my-4">Dashboard</h1>
	
	<form class="row" method="POST" action="/dosen/profil/ubah">
        @csrf
        <div class="col-12 col-md-6">
	        <div class="form-input mb-3">
	        	<label>Nama</label>
	        	<input type="text" name="nama_dsn" class="form-control" value="{{ $data->nama_dsn }}" required>
	        </div>
	        <div class="form-input mb-3">
	        	<label>Email</label>
	        	<input type="email" name="email" class="form-control" value="{{ $data->email }}" required>
	        </div>
	    </div>
	    <div class="col-12 col-md-6">
	        <div class="form-input mb-3">
	        	<label for="password">Password Baru</label>
	        	<div class="input-group">
	        		<input type="password" name="password" class="form-control" placeholder="Password" autocomplete="new-password">
	        		<span class="input-group-text password fas fa-eye-slash
	        		" style="padding-top: 0.56rem;"></span>
	        	</div>
	        </div>

	        <div class="form-input">
		        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
	        </div>
	    </div>
     </form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var $pass = $('[name="password"]');

		$('.password').click(function(){
			if($pass.attr('type') == 'password'){
				$pass.attr('type', 'text');
				$(this).addClass('fa-eye')
					.removeClass('fa-eye-slash');
			} else {
 				$pass.attr('type', 'password');
 				$(this).addClass('fa-eye-slash')
 					.removeClass('fa-eye');
 			}
		});
	});
</script>

@endsection