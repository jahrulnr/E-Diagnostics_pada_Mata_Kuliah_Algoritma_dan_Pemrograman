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
    <h1 class="my-4">Kelola Akun Mahasiswa</h1>
	<div class="row">
	    <div class="col-12">
	        <table class="table table-bordered" id="table_data">
	        	<thead>
	        		<th>No.</th>
	        		<th>NPM</th>
	        		<th>Nama</th>
	        		<th>Kelas</th>
	        		<th>Email</th>
	        		<th>Aksi</th>
	        	</thead>
	        	<tbody><?php $i = 1; ?>
	        		@foreach($data as $d)
	        		<tr>
	        			<td align="center">{{ $i++ }}.</td>
	        			<td>{{ $d->npm }}</td>
	        			<td>{{ $d->nama_mhs }}</td>
	        			<td class="ucfirst" align="center">{{ $d->kelas }}</td>
	        			<td>
	        				<span onclick="window.open('mailto:{{ $d->email }}', 'mail')">{{ $d->email }}</span>
	        			</td>
	        			<td align="center">
	        				<data id="data-{{ $d->npm}}" class="d-none">{{ json_encode($d) }}</data>
									<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah" onclick="edit('#data-{{ $d->npm}}')">
										<span class="fas fa-pencil-alt"></span>
									</button>
									<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus('{{ $d->npm}}')">
										<span class="fas fa-trash"></span>
									</button>
	        			</td>
	        		</tr>
	        		@endforeach
	        	</tbody>
	        </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambah_header">Tambah Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @csrf
        <div class="form-input mb-3">
        	<label for="npm">NPM</label>
        	<input type="text" name="npm" class="form-control" placeholder="173500000" required>
        </div>
        <div class="form-input mb-3">
        	<label>Nama</label>
        	<input type="text" name="nama_mhs" class="form-control" placeholder="Nama" required>
        </div>
        <div class="form-input mb-3">
        	<label>Email UIR 
        		<sup><font color="red">*Wajib @<?=customConfig::student_host_mail?></font></sup>
        	</label>
        	<input type="email" name="email" class="form-control" placeholder="user@<?=customConfig::student_host_mail?>" required>
        </div>
        <div class="form-input mb-3">
        	<label>Kelas</label>
        	<select name="kelas" class="form-select" required>
        		<option selected disabled>-- Pilih Kelas Mahasiswa</option>
        		@foreach($kelas as $kls)
        		<option value="{{ $kls->id_kelas }}">{{ $kls->kelas }} ({{ $kls->nama_dsn }})</option>
        		@endforeach
        	</select>
        </div>
        <div class="form-input mb-3">
        	<label for="password">Password </label>
        	<input type="password" name="password" class="form-control" placeholder="Password" required>
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
           Hapus Mahasiswa
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	Yakin menghapus mahasiswa ini?<br/>
      	<small class="text-danger">
      		* Menghapus mahasiswa akan menghapus semua data yang terkait. (Ex. Jawaban dan Nilai)
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
	var $form = $('form')[0];

	function tambah(){
		$('form').attr('action', '/admin/mahasiswa/tambah');
		$('#tambah_header').html("Tambah Akun Mahasiswa");
		$form.reset();
		$('label[for="npm"]').html('NPM <sup class="text-danger">*Format: xx3510xxx</sup>');
		$('input[name="npm"]').removeAttr('readonly');
		$('label[for="password"]').html('Password <sup>(Default: 123456)</sup>');
		$('input[name="password"]').attr('required', 'required');
		$('input[name="password"]').val('123456');
	}

	function edit(id){
		$('form').attr('action', '/admin/mahasiswa/ubah');
		$('#tambah_header').html("Ubah Akun Mahasiswa");
		$form.reset();
		var data = JSON.parse($(id).html());
		$('label[for="npm"]').html('NPM');
		$('label[for="password"]').html('Password <sup class="text-danger">*Optional</sup>');
		$('input[name="npm"]').attr('readonly', 'readonly');
		$('input[name="npm"]').val(data['npm']);
		$('input[name="nama_mhs"]').val(data['nama_mhs']);
		$('input[name="email"]').val(data['email']);
		$('input[name="password"]').removeAttr('required');
		$('select[name="kelas"]').val(data['id_kelas']);
	}

	function hapus(id){
		$('#hapus_data').attr('href', '/admin/mahasiswa/hapus/' + id);
	}

	function importExcel(){
		$('#btn_import').click(function(){
			$('[name="tes"]').trigger('click');
		});
	}

	$(document).ready(function(){
  	var hash = window.location.hash;
  	if(hash == "#npm_tidak_valid"){
  		toastr.error("NPM tidak valid");
  	}
  	else if(hash == "#email_tidak_valid"){
  		toastr.error("Email tidak valid");
  	}

  	$('[name="kelas"]').on("input", function(){
  		var val = this.value;
  		if(val.length > 1){
  			val = val.substr(0, 1);
  		}
  		$(this).val(val.toUpperCase());
  	});

		$('#table_data').DataTable({
		  "responsive": true,
		  "autoWidth": false,
		  "language": {
			  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
		  },
		  "fnDrawCallback": function (oSettings){
			$('.dataTables_filter').each(function () {
				if($('#btn_add').length < 1){
					$(this).append('<button class="btn btn-primary btn-sm btn_datatables" id="btn_add" data-bs-toggle="modal" data-bs-target="#tambah" onclick="tambah()">Tambah</button>');
					importExcel();
				}
			});
		  }
		});
	});
</script>

@endsection