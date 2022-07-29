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
	<h1 class="mt-4">Materi {{ $judul_materi }}</h1>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="table_data">
				<thead>
					<tr>
						<th>No.</th>
						<th>NPM</th>
						<th>Nama</th>
						<th>Nilai</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="view-jawaban" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <form method="POST" action="/dosen/materi/penilaian/nilai" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Periksa Jawaban</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" name="npm" required>
        <input type="hidden" name="id_materi" required>
        <input type="hidden" name="soal_total" required>
        <div class="form-input mb-3">
        	<label>Nama</label>
        	<input type="text" name="nama" class="form-control" readonly>
        	<label>Email</label>
        	<input type="email" name="email" class="form-control" readonly>
        	<label>Kelas</label>
        	<input type="text" name="kelas_mhs" class="form-control" readonly>
        </div>
        <table class="table table-bordered table-responsive w-100" id="table-soal">
        	<thead>
        		<tr>
        			<th>No.</th>
        			<th>Soal</th>
        			<th>Kunci Jawaban</th>
        			<th>Jawaban Mahasiswa</th>
        			<th>Bobot</th>
        			<th>Poin</th>
        		</tr>
        	</thead>
        	<tbody id="list-soal"></tbody>
        </table>
      </div>
      <div class="modal-footer">
      	<div class="btn btn-light" style="cursor: auto !important;">
      		Poin <span id="poin-akhir"></span>/<span id="poin-total"></span>
      	</div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Template -->
<div class="d-none">
	<div id="inp_kelas">
		Kelas: 
		<select name="kelas" class="form-select form-select-sm d-inline-block w-auto" onchange="update_kelas(this)">
			<option disabled>-- Pilih Kelas</option>
			@foreach($kelas as $data)
			<option value="{{ $data->id_kelas }}">{{ $data->kelas }}</option>
			@endforeach
		</select>
	</div>
	<div id="td_aksi">
		<button class="btn btn-primary" onclick="view_jawaban('--NPM--');" disabled>
			<span class="far fa-clipboard px-1"></span>
		</button>
	</div>
	<div id="div-soal">
		<tr_table>
			<td_table style="width:1px">--NO--</td_table>
			<td_table class="text-justify" style="white-space: pre-wrap;">--SOAL--</td_table>
			<td_table class="text-justify" style="white-space: pre-wrap;">--JAWABAN_SOAL--</td_table>
			<td_table class="text-justify" style="white-space: pre-wrap;">--JAWABAN_MHS--</td_table>
			<td_table class="text-center">--BOBOT--</td_table>
			<td_table bobot="--BOBOT--">
				<input type="number" class="form-control form-control-sm bobot-input" style="min-width: 50px;" min="0" max="--BOBOT--" name="id_soal[--ID_SOAL--]" placeholder="--BOBOT--" value="--BOBOT_JAWABAN--" onchange="count(this)" required>
			</td_table>
		</tr_table>
	</div>
</div>

<script type="text/javascript">
	var table_mhs = $('#table_data').DataTable({
	  "responsive": true,
	  "autoWidth": false,
	  "language": {
		  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
	  },
	  "columnDefs": [
	    { className: "text-center", targets: [ 0, 3, 4 ] }
	  ],
	  "fnDrawCallback": function (oSettings){
			$('.dataTables_filter').each(function () {
				if($('#opt_kelas').length < 1)
				$(this).append(' <label id="opt_kelas">'
					+ '<script>inp_kelas();<\/script>'
					+ '</label>');
			});
	  }
	});
	
	function update_kelas(id){
		var kelas = $(id).val();
		window.location.hash = "id_kelas=" + kelas;
		getMhs(kelas);
	}

	function inp_kelas(){
		var html = $('#inp_kelas').find('select[name="kelas"]');
		if( window.location.hash.substr(0, 10) == "#id_kelas=" ){
			getMhs(window.location.hash.substr(10));
			html = html.val(window.location.hash.substr(10));
		}
		else
			getMhs($('select[name="kelas"]').val());

		$('#opt_kelas').html(html.parent());
	}

	function table_draw(table, data){
		table.clear();
    table.rows.add(data);
    table.draw();
	}

	function getMhs(kelas){
		var template = $('#tabel_data').html();
		var aksi = $('#td_aksi').html();
		var request = $.ajax({
		  url: "/dosen/materi/penilaian/kelas/" + kelas,
		  success: function(json){
		  	var tb = [];
				$('form.modal-content').attr('action', 
					$('form.modal-content').attr('action') + window.location.hash);

     		$.each(json, function(i, v){
     			var aksi_temp = aksi.replaceAll('--NPM--', v.npm);
     			if(v.c_jawaban > 0) aksi_temp = aksi_temp.replace('disabled', '');
     			var data_temp = [(i+1) + ".", v.npm, v.nama_mhs, (v.nilai == null || v.nilai == '-') ? '-' : Math.round(v.nilai * 100) / 100 || 0, aksi_temp];
     			tb.push(data_temp);
     			console.log(v);
     		});

 				table_draw(table_mhs, tb);
  		}
		});

		request.fail(function(jqXHR, textStatus) {
		  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
		});
	}

	function view_jawaban(npm){
		var request = $.ajax({
		  url: "/dosen/materi/penilaian/" + window.location.pathname.substr(-1) + "/" + npm,
		  success: function(data){
		  	if(data !== false){
			  	var template = $('#div-soal').html();
			  	var div = "";
			  	var point_akhir = 0.0;

			  	$('input[name="npm"]').val(data[0].npm);
			  	$('input[name="id_materi"]').val(data[0].id_materi);
			  	$('input[name="soal_total"]').val(data.total_bobot);
			  	$('input[name="nama"]').val(data[0].nama_mhs);
			  	$('input[name="email"]').val(data[0].email);
			  	$('input[name="kelas_mhs"]').val(data[0].kelas);
			  	$('#poin-total').html(data.total_bobot);
			  	var j = 1;
			  	$.each(data, function(i, v){
			  		if(i != "total_bobot"){
				  		div += template
				  			.replaceAll('_table', '')
				  			.replace('--NO--', (j++) + ".")
				  			.replace('--ID_SOAL--', v.id_soal)
				  			.replace('--SOAL--', v.soal)
				  			.replace('--JAWABAN_SOAL--', v.jawaban_soal)
				  			.replaceAll('--BOBOT--', v.bobot)
				  			.replace('--JAWABAN_MHS--', v.jawaban_mhs)
				  			.replaceAll('--INDEX--', v.id_soal)
				  			.replace('--BOBOT_JAWABAN--', v.bobot_jawaban);
			  			point_akhir += v.bobot_jawaban || 0;
			  		}
			  	});
		  		$('#poin-akhir').html(point_akhir);
			  	$('#list-soal').html(div);
			  	$('#view-jawaban').modal('show');
			  }
			  else {
			  	toastr.error('Server error. Jika terus berlanjut, silakan hubungi admin.')
			  }
  		}	
		});

		request.fail(function(jqXHR, textStatus) {
		  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
		});
	}

	function count(data){
		var nilai_temp = 0.0;
		$('#table-soal .bobot-input').each(function(i, v){
			var bobot = $(v).parents('td').attr('bobot');
			var nilai_bobot = $(v).val() * 1.0 || 0;
			if(nilai_bobot > bobot){
				nilai_bobot = bobot;
				$(v).val(bobot);
			}
			nilai_temp += nilai_bobot * 1.0;
		});
  	$('#poin-akhir').html(nilai_temp);
	};
</script>

@endsection