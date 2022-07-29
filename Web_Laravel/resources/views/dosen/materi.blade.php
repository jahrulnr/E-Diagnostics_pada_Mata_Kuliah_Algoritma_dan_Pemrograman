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
<!-- Upload -->
<script type="text/javascript">
	var Upload = function (file, id) {
  	this.file = file;
  	this.id = id;
	};
</script>

<div class="container-fluid px-4">
	<h1 class="my-4">Kelola Materi</h1>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="table_data">
				<thead>
					<th>No.</th>
					<th>Soal</th>
					<th>Kunci Jawaban</th>
					<th>Bobot</th>
					<th>Aksi</th>
				</thead>
				<tbody></tbody>
			</table>
			<table_data class="d-none">
				<div class="table_aksi">
					<data id="data---ID-SOAL--" class="d-none">--DATA-JSON--</data>
					<button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#form_soal" onclick="info('#data---ID-SOAL--')">
						<span class="fas fa-info px-1"></span>
					</button>
					<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#form_soal" onclick="edit('#data---ID-SOAL--')">
						<span class="fas fa-pencil-alt"></span>
					</button>
					<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus('--ID-SOAL--')">
						<span class="fas fa-trash"></span>
					</button>
				</div>
			</table_data>
		</div>
	</div>
</div>

<!-- Modal Berkas Materi -->
<div class="modal fade" id="form_materi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Materi</h5>
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
      			@foreach($materi as $m)
      			<tr>
      				<td>{{ $m->judul_materi }}</td>
      				<td class="text-center">{{ $m->pertemuan }}</td>
      				<td style="width: 40%">
      					<div class="row" id="file-{{ $m->id_materi }}">
      					@for($f = 0; $f < count($files[$m->id_materi]); $f++)
        					<div class="col-12 d-flex justify-content-between mb-1">
        						<label>{{ substr(basename($files[$m->id_materi][$f]), strpos(basename($files[$m->id_materi][$f]), "- ")+2) }}</label>
        						<div class="btn-group my-auto" role="group">
	        						<a href="/files/materi/{{ basename($files[$m->id_materi][$f]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Unduh">
	        							<span class="fas fa-download"></span> 
	        						</a>
	        						<a href="/dosen/materi/berkas/hapus/{{ basename($files[$m->id_materi][$f]) }}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus">
	        							<span class="fas fa-trash"></span> 
	        						</a>
	        					</div>
        					</div>
      					@endfor
        					<div class="col-12 d-flex justify-content-end materi-upload">
        						<input type="file" name="tf_materi" id="tf_{{ $m->id_materi }}" data-id="{{ $m->id_materi }}" class="d-none" accept=".pdf,.doc,.docx,.xlsx,.xlsm,.xlsb,.rar,.zip,.7z,.tar,.gz,.txt,.jpeg,.jpg,.png,.gif"/>
        						
        						<div class="input-group input-group-sm d-flex justify-content-end">
        							<div id="progress-{{ $m->id_materi }}" class="file-progress progress h-100" style="display:none;width:100px">
										    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
											    <div class="status">0%</div>
										    </div>
											</div>
											<button type="button" class="btn btn-success btn-sm btn_tf" target-input="#tf_{{ $m->id_materi }}">
        								<span class="fas fa-plus"></span>
        							</button>
        							<label class="input-group-text"><small>Max. 2MB</small></label>
	        					</div>
        					</div>
        				</div>
      				</td>
      			</tr>
      			@endforeach
      		</tbody>
      	</table>
      	<div class="d-none" id="temp_fmateri">
					<div class="col-12 d-flex justify-content-between mb-1">
						<label>--FILE--</label>
						<div class="btn-group my-auto" role="group">
  						<a href="--LINK--" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Unduh">
  							<span class="fas fa-download"></span> 
  						</a>
  						<a href="--HAPUS--" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus">
  							<span class="fas fa-trash"></span> 
  						</a>
  					</div>
					</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
      </div>
    </div>
  </div>
</div>

<!-- Modal tambah soal -->
<div class="modal fade" id="form_soal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambah_header">Tambah Soal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" name="id_soal">
        <div class="form-input mb-3">
        	<label>Judul Materi</label>
        	<select type="text" name="id_materi" class="form-select" required>
        		<option disabled>-- Pilih Materi</option>
        		@foreach($materi as $m)
        			<option value="{{ $m->id_materi }}">{{ $m->judul_materi }}</option>
        		@endforeach
        	</select>
        </div>
        <div class="form-input mb-3">
        	<label>Soal</label>
        	<textarea name="soal" class="form-control" rows="5" placeholder="Soal" required></textarea>
        </div>
        <div class="form-input mb-3">
        	<label>Kunci Jawaban</label>
        	<textarea name="jawaban_soal" class="form-control" rows="2" placeholder="Jawaban" required></textarea>
        </div>
        <div class="form-input mb-3">
        	<label>Bobot Soal</label>
        	<input type="number" min="0" value="" name="bobot" class="form-control" placeholder="Bobot Soal" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="label_hapus" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label_hapus">
           Hapus Soal
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	Yakin menghapus soal ini?<br/>
      	<small class="text-danger">
      		* Menghapus soal akan menghapus semua data yang terkait. (Ex. Jawaban, Hasil Diagnosis, dll.)
      	</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        	Tidak
        </button>
        <a href="#" class="btn btn-danger" id="hapus_data">
        	Ya
        </a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	// upload materi 
	$(".btn_tf").click(function(){
		$($(this).attr("target-input")).trigger("click");
	});

	$('input[name="tf_materi"]').change(function(){
		var file = $(this)[0].files[0];
		var upload = new Upload(file, $(this).attr("data-id"));
		console.log(upload.getSize());
		if(upload.getSize() > (1024*1024*2)){
			toastr.error("Ukuran file lebih dari 2MB");
		}
		else{
			$("#progress-" + $(this).attr("data-id")).show();
			upload.doUpload("/dosen/materi/berkas/upload/" + $(this).attr("data-id"), "{{ csrf_token() }}");
		}
	});

	var $form = $('form')[0];
	var $input = $('form').find('select, textarea, input');

	function info(id){
		edit(id);
		$('#tambah_header').html("Rincian Soal Materi");
		$.each($input, function(i, v){
			$(v).attr('disabled', 'disabled');
		});
		$('form button[type="submit"]').hide();
	}

	function tambah_soal(){
		$('form').attr('action', '/dosen/soal/tambah#materi=' + $('#data_materi').val());
		$('#tambah_header').html("Tambah Soal");
		$form.reset();
		$.each($input, function(i, v){
			$(v).removeAttr('disabled');
		});
		$('form button[type="submit"]').show();
		if($('#jumlah_bobot').html()*1.0 < 100 || $('#jumlah_bobot').html() == null){
			$("#form_soal").modal('show');
			$("#form_soal").find('select').val($('#data_materi').val());
		}
		else
			toastr.error("Bobot melebihi batas (Maks. 100).<br/>Silakan kurangi bobot soal terlebih dahulu.");
	}

	function edit(id){
		var data = JSON.parse($(id).html());
		$('form').attr('action', '/dosen/soal/ubah#materi=' + $('#data_materi').val());
		$('#tambah_header').html("Ubah Soal");
		$form.reset();
		$.each($input, function(i, v){
			$(v).removeAttr('disabled');
		});
		$('input[name="id_soal"]').val(data['id_soal']);
		$('select[name="id_materi"]').val(data['id_materi']);
		$('textarea[name="soal"]').val(data['soal']);
		$('textarea[name="jawaban_soal"]').val(data['jawaban_soal']);
		$('input[name="bobot"]').val(data['bobot']);
		$('form button[type="submit"]').show();
	}

	function hapus(id){
		$('#hapus_data').attr('href', '/dosen/soal/hapus/' + id + '#materi=' + $('#data_materi').val());
	}

	var table;
	var table_opt = {
	  "responsive": true,
	  "autoWidth": false,
	  "language": {
		  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
	  },
	  columnDefs: [
	  	{targets: 0,className: 'text-center'},
	  	{targets: 3,className: 'text-center'},
	  	{targets: 4,className: 'text-center'}
  	],
	  initComplete: function (settings, json){
			$('.dataTables_filter')
				.append(
					' <span class="d-none d-md-inline">|</span> <button class="btn btn-primary btn-sm mb-1"  data-bs-toggle="modal" data-bs-target="#form_materi"> Materi</button>' +
					' <span class="d-none d-md-inline">|</span> <button class="btn btn-primary btn-sm mb-1" id="btn_add" onclick="tambah_soal()">Tambah Soal</button>'
					);
			$('#table_data_length')
				.append('<div class="mb-1 ms-1 d-md-inline d-block"><span class="d-none d-md-inline">|</span> Materi: <select class="form-select form-select-sm w-auto d-inline" style="max-width: 40%;" id="data_materi">'+
					$('select[name="id_materi"]').html() +
					'</select></div>');

			var hash = window.location.hash;
			if(hash.search('materi') > 0)
				if(hash.search('&') > 0)
					$('#data_materi').val(hash.substr(8, (window.location.hash).search('&')-8));
				else
					$('#data_materi').val(hash.substr(8));
			if($('#data_materi').val() != null) update_table();
			$('#data_materi').change(function(){
				update_table();
			});
	  }
	};

	table = $('#table_data').DataTable(table_opt);

	function update_table(){
		var id_materi = $('#data_materi').val();
		var tmp_row = $('.table_aksi').html()
			.replaceAll('tr_data', 'tr').replaceAll('td_data', 'td');
		var tb_data = [];
		$.ajax({
			url: '/dosen/materi/' + id_materi,
			type: "GET",
			success: function(msg){
				if(msg.data == null)
					tb_data = [];
				else {
					$.each(msg.data, function(i, v){
						var data_temp = [
							(i+1) + ".",
							v.soal.length > 40 ? v.soal.substr(0, 40) + "..." : v.soal,
							v.jawaban_soal.length > 40 ? v.jawaban_soal.substr(0, 40) + "..." : v.jawaban_soal,
							v.bobot,
							tmp_row.replace("--DATA-JSON--", JSON.stringify(v))
								.replaceAll("--ID-SOAL--", v.id_soal)
						];
						tb_data.push(data_temp);
					});
				}
				table.clear();
				table.rows.add(tb_data);
				table.draw();
				$("#table_data_paginate .pagination").prepend("<div class='my-auto me-3'>Total Bobot: <span id='jumlah_bobot'>"+ msg.jumlah_bobot +"</span></div>");
			}
		})
		.fail(function(jqXHR, textStatus) {
		  alert( "Jaringan Error, Coba lagi nanti. (" + textStatus + ")");
		});

		Upload.prototype.getType = function() {
		    return this.file.type;
		};
		Upload.prototype.getSize = function() {
		    return this.file.size;
		};
		Upload.prototype.getName = function() {
		    return this.file.name;
		};
		Upload.prototype.doUpload = function (url_target, csrf) {
		    var that = this;
		    var formData = new FormData();
		    formData.append("_token", csrf);
		    formData.append("file", this.file, this.getName());
		    formData.append("upload_file", true);

		    $.ajax({
		        type: "POST",
		        url: url_target,
		        xhr: function () {
		            var myXhr = new window.XMLHttpRequest();
		            if (myXhr.upload) {
	                myXhr.upload.addEventListener('progress', function (event) {
								    var percent = 0;
								    var position = event.loaded || event.position;
								    var total = event.total;
								    var progress_bar_id = "#progress-" + that.id;
								    if (event.lengthComputable) {
								        percent = Math.ceil(position / total * 100);
								    }
								    var $progress_bar = $(progress_bar_id + " .progress-bar");
								    $progress_bar.css("width", percent + "%");
								    $progress_bar.attr("aria-valuenow", percent);
								    $(progress_bar_id + " .status").text(percent + "%");
									});
		            }
		            return myXhr;
		        },
		        success: function (data) {
		        	if(data.status == "success"){
		            var temp = $("#temp_fmateri").html();
		            temp = temp.replace("--FILE--", data.nama)
		            .replace("--LINK--", "{{ asset("files/materi") }}/" + data.nama_f)
		            .replace("--HAPUS--", "/dosen/materi/berkas/hapus/" + data.nama_f);
								$("#progress-" + that.id).hide();

		            $("#file-" + that.id).prepend(temp);
		          }
		          else {
		          	toastr.error("Berkas gagal diupload");
		          }

		        },
		        error: function (error) {
		            toastr.error("Upload gagal");
		            console.log(error);
		        },
		        async: true,
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        timeout: 60000
		    });
		};
	}
</script>

@endsection