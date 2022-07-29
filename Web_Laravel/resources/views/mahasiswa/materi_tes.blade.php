@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<!-- Plugin -->
<style>
	/* DataTables */
	@import url('/vendor/datatables/css/dataTables.bootstrap5.min.css');
	@import url('/vendor/datatables/css/responsive.bootstrap5.min.css');
	/* Toastr */
	@import url('/vendor/toastr/toastr.min.css');

	/* Custom style */
	#tab-soal {
		flex-wrap: nowrap;
		overflow-x: auto;
		overflow-y: clip;
		scrollbar-width: thin;

		/* Fix border */
		border-bottom: none;
  	border-top: 1px solid #dee2e6 !important;
	}

	.dark-bg #tab-soal {
		border-bottom: none;
  	border-top: 1px solid var(--bs-gray-600) !important;
	}

	#tab-soal .nav-item {
		white-space: nowrap;
	}

	#tab-soal, #tab-soal .nav-item {
    transform:rotateX(180deg);
    -ms-transform:rotateX(180deg); /* IE 9 */
    -webkit-transform:rotateX(180deg); /* Safari and Chrome */
	}
</style>
<!-- DataTables -->
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables/js/responsive.bootstrap5.min.js"></script>
<!-- Toastr -->
<script src="/vendor/toastr/toastr.min.js"></script>

<div class="container-fluid px-4">
	<h1 class="mt-4 mb-0">Materi {{ $materi->judul_materi }}</h1>
	<h3>Pertemuan {{ $materi->pertemuan }}</h3>
	<div class="d-flex justify-content-center">
		<div class="col-12" id="card-col">
			<div class="card shadow">

			@if( $soal_count > 0 && $jawaban === false )
				<div class="card-body" id="form_soal">
					<ul class="nav nav-tabs overflow-x-auto" id="tab-soal" role="tablist">
				  	@for( $i=1; $i<=$soal_count; $i++ )
				  	<li class="nav-item" role="presentation">
				    	<button class="nav-link" id="dataSoal-{{ $i }}-tab" data-bs-toggle="tab" data-bs-target="#dataSoal-{{ $i }}" type="button" role="tab" aria-controls="dataSoal-{{ $i }}" aria-selected="true">
				    		<span>Soal</span> {{ $i }}
				    		<span class="fas fa-check text-success isi" style="display:none"></span>
				    	</button>
				  	</li>
				  	@endfor
				  	<li class="nav-item" role="presentation">
				    	<button class="nav-link" id="last-tab-li" data-bs-toggle="tab" data-bs-target="#last-tab-div" type="button" role="tab" aria-controls="last-tab-div" aria-selected="true">
				    		Selesai
				    	</button>
				  	</li>
					</ul>

					<form class="tab-content" id="tab-soal-content" method="POST"><?php $i = 1; ?>
				  	@foreach($soal as $data)
				  	<div class="tab-pane fade" id="dataSoal-{{ $i }}" role="tabpanel" aria-labelledby="dataSoal-{{ $i }}-tab">
				  		<div class="form-input">
				  			<label style="white-space: pre-wrap">{{ $data->soal }}<hr class="my-3">Jawab (Bobot: {{ $data->bobot }})</label>
				  			<textarea class="form-control area-jawaban" rows="5" name="jawaban[{{ $data->id_soal }}]" placeholder="Jawab ..." button-parent="#dataSoal-{{ $i++ }}-tab"></textarea>
				  		</div>
				  	</div>
				  	@endforeach
			  		<div class="tab-pane fade" id="last-tab-div" role="tabpanel" aria-labelledby="last-tab-li">
				  		<div class="form-input">
				  			@csrf
				  			<u class="h5">Konfirmasi</u>
				  			<div class="mt-1">
				  				&nbsp;&nbsp;Mohon cek kembali form yang telah dijawab sebelum menyelesaikan tes.
					  			<div class="mt-3 w-100 text-center">
						  			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#send_confirm">Kirim Jawaban</button>
					  			</div>
				  			</div>
				  		</div>
				  		<!-- Modal -->
						<div class="modal fade" id="send_confirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-sm">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Jawaban</h5>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-body">
						        Yakin untuk mengirim jawaban?
						      </div>
						      <div class="modal-footer">
						        <button type="submit" class="btn btn-primary">Konfirmasi</button>
						        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
						      </div>
						    </div>
						  </div>
						</div>
				  	</div>
				  </form>
				</div>

			@elseif( $jawaban === true )
				<div class="card-body">
					<div class="form-input mb-3 text-center">
						<label class="mb-3">
							Kamu sudah menjawab materi ini
						</label><br/>
						<a class="btn btn-primary" href="/mahasiswa/materi">
							Kembali
						</a>
					</div>
				</div>

			@else
				<div class="card-body">
					<div class="form-input mb-3 text-center">
						<label class="mb-3">
							Soal belum tersedia
						</label><br/>
						<a class="btn btn-primary" href="/mahasiswa/materi">
							Kembali
						</a>
					</div>
				</div>

			@endif
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('button[data-bs-toggle="tab"]').click(function(){
			$('.area-jawaban').each(function(i, v){
				if($(this).val().length > 0){
					var parent = $(this).attr('button-parent');
					$(parent + " .isi").show();
				}
			});
		});

		if($('#form_soal .nav-item .nav-link.active').length == 0){
			$($('#form_soal .nav-item .nav-link')[0]).trigger('click');
		}
	});
</script>
@endsection