@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<div class="container-fluid px-4">
	<div class="d-flex justify-content-between">
    	<h1 class="my-4">Dashboard</h1>
    	<div class="my-auto">
	    	<button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#server_stats" >
	    		Server Status
	    	</button>
    	</div>
	</div>

	<div class="modal fade" id="server_stats" tabindex="-1" role="dialog" aria-labelledby="label_hapus" aria-hidden="true">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">
	           Server Status
	        </h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
        	<table class="table-borderless text-dark">
        		<tr>
        			<td align="left">CPU</td>
        			<td align="left">: {{ $cpu }}</td>
        		</tr>
        		<tr>
        			<td align="left">RAM</td>
        			<td align="left">: {{ $ram }}</td>
        		</tr>
        		<tr>
        			<td align="left" class="pe-2">Uptime</td>
        			<td align="left">: {{ $uptime }}</td>
        		</tr>
        	</table>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">   
	        	Kembali
	        </button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="importDB" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <form method="POST" action="/admin/importExcel" enctype="multipart/form-data" class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">
	           Import Data Dosen dan Mahasiswa
	        </h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
      		<p class="mb-3">Unduh templatenya di <a href="/files/DataMahasiswa.xlsx">sini</a></p>
      		@csrf
      		<input type="file" name="excel" accept=".xlsx" class="form-control" required>
      		<div class="text-end">
      		</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">   
	        	Kembali
	        </button>
      		<button class="btn btn-primary">
      			Import
      		</button>
	      </div>
	    </form>
	  </div>
	</div>

	<div class="row">
	    <div class="col-xl-3 col-md-6">
	        <a href="/admin/dosen" class="card bg-secondary text-white mb-4 pt-2 text-center">
	        	<div class="card-header"><span class="fas fa-user fa-4x"></span></div>
	            <div class="card-body">Dosen</div>
	        </a>
	    </div>
	    <div class="col-xl-3 col-md-6">
	        <a href="/admin/mahasiswa" class="card bg-primary text-white mb-4 pt-2 text-center">
	        	<div class="card-header"><span class="fas fa-users fa-4x"></span></div>
	            <div class="card-body">Mahasiswa</div>
	        </a>
	    </div>
	    <div class="col-xl-3 col-md-6">
	        <a href="/admin/materi" class="card bg-success text-white mb-4 pt-2 text-center">
	        	<div class="card-header"><span class="fas fa-book fa-4x"></span></div>
	            <div class="card-body">Materi</div>
	        </a>
	    </div>
	    <div class="col-xl-3 col-md-6">
	        <a href="#" class="card bg-secondary text-white mb-4 pt-2 text-center" data-bs-toggle="modal" data-bs-target="#importDB">
	        	<div class="card-header"><span class="fas fa-file-import fa-4x"></span></div>
	            <div class="card-body">Import Dosen & Mahasiswa</div>
	        </a>
	    </div>
	</div>
</div>

<style type="text/css">
	/* Toastr */
	@import url('/vendor/toastr/toastr.min.css');
</style>
<script src="/vendor/toastr/toastr.min.js"></script>
<script type="text/javascript">
	@if($msg = Session::get('success'))
	toastr.success('{{ $msg[0] }} Dosen dan {{ $msg[1] }} Mahasiswa berhasil diimport');
	@endif
</script>

@endsection