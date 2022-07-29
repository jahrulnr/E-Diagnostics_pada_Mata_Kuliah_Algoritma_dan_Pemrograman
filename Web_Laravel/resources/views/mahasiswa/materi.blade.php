@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<div class="container-fluid px-4">
	<div class="d-flex justify-content-between">
		<h1 class="my-4">Materi</h1>
		<div class="h-100 my-auto">
		  	<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#d_modal">
			  Download Materi
			</button>
			<div class="modal fade" id="d_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Download Materi</h5>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
			        <table class="table table-bordered">
			      		<thead>
			      			<tr>
		    					<th>
		    						Judul Materi
		    					</th>
		    					<th>
		    						Pertemuan
		    					</th>
		    					<th>
		    						Berkas
		    					</th>
			      			</tr>
			      		</thead>
			      		<tbody>
			      			@foreach($data as $m)
			      			<tr>
			      				<td>{{ $m->judul_materi }}</td>
			      				<td class="text-center">{{ $m->pertemuan }}</td>
			      				<td style="width: 40%">
		      						@for($f = 0; $f < count($files[$m->id_materi]); $f++)
		        					<div class="col-12 d-flex justify-content-between mb-1">
		        						<label>{{ substr(basename($files[$m->id_materi][$f]), strpos(basename($files[$m->id_materi][$f]), "- ")+2) }}</label>
		        						<a href="/files/materi/{{ basename($files[$m->id_materi][$f]) }}" class="btn btn-primary btn-sm my-auto" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Unduh">
		        							<span class="fas fa-download"></span> 
		        						</a>
		        					</div>
		      						@endfor
			      				</td>
			      			</tr>
			      			@endforeach
			      		</tbody>
			      	</table>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
	<div class="row">
		@foreach($data as $materi)
		<a href="/mahasiswa/materi/{{ $materi->id_materi }}" class="col-12 col-md-4 mb-3">
			<div class="card card-body menu-materi">
				<div class="row">
					<div class="col-4 text-end">
						<span style="font-size: 4rem;font-weight: bolder;">{{ $materi->pertemuan }}</span>
					</div>
					<div class="col-8 my-auto">
						Materi
						@if($materi->id_jawaban != null)
						<span class="fas fa-check text-success"></span>
						@endif
						<hr class="m-0" />
						{{ $materi->judul_materi }}
					</div>
				</div>
			</div>
		</a>
		@endforeach
	</div>
</div>

@endsection