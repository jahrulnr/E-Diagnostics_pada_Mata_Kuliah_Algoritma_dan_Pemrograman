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
  <h1 class="my-4">Kelola Akun Dosen</h1>
	<div class="row">
    <div class="col-12">
      <table class="table table-bordered" id="table_data">
      	<thead>
      		<th>No.</th>
      		<th>Nama</th>
      		<th>Email</th>
      		<th>Kelas</th>
      		<th>Hak Akses</th>
      		<th>Aksi</th>
      	</thead>
      	<tbody><?php $i = 1; ?>
      		@foreach($data as $d)
      		<tr>
        		<td align="center">{{ $i++ }}.</td>
        		<td>{{ $d->nama_dsn }}</td>
        		<td>{{ $d->email }}</td>
        		<td>{{ $d->kelas }}</td>
        		<td class="ucfirst">{{ $d->hak_akses }}</td>
        		<td align="center">
							<data id="data-{{ $d->id_admin}}" class="d-none">{{ json_encode($d) }}</data>
							<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah" onclick="edit('#data-{{ $d->id_admin}}')">
								<span class="fas fa-pencil-alt"></span>
							</button>
							<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus('{{ $d->id_admin}}')">
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
<div class="modal fade" id="tambah" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambah_header">Tambah Dosen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" name="id_admin">
        <div class="form-input mb-3">
        	<label>Nama</label>
        	<input type="text" name="nama_dsn" class="form-control" placeholder="Jahrul Novario" required>
        </div>
        <div class="form-input mb-3">
        	<label>Email</label>
        	<input type="email" name="email" class="form-control" placeholder="jahrulnr@example.com" required>
        </div>
        <div class="form-input mb-3">
        	<label for="password">Password</label>
        	<input type="password" name="password" class="form-control" placeholder="*******" required>
        </div>
        <div class="form-input mb-3">
        	<label>No. HP</label>
        	<input type="text" name="noHP" class="form-control" placeholder="0822xxxxxxxx" required>
        </div>
        <div class="form-input mb-3">
        	<label>Kelas</label>
        	<input name="kelas" class="form-control" placeholder="A, B, C, ..., n" required>
        </div>
        <div class="form-input mb-3">
        	<label>Hak Akses</label>
        	<select name="hak_akses" class="form-select" required>
        		<option selected disabled>-- Pilih Hak Akses</option>
        		<option value="admin">Admin</option>
        		<option value="dosen">Dosen</option>
        	</select>
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
           Hapus Dosen
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	Yakin menghapus dosen ini?<br/>
      	<small class="text-danger">
      		* Menghapus dosen akan menghapus semua data yang terkait. (Ex. Soal, Jawaban, Hasil Diagnosis, dll.)
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
		$('form').attr('action', '/admin/dosen/tambah');
		$('#tambah_header').html("Tambah Akun Dosen");
		$form.reset();
		$('label[for="password]"').html('Password');
		$('input[name="id_admin"]').removeAttr('required');
		$('input[name="password"]').attr('required', 'required');
		$('input[name="kelas"]').removeAttr('disabled');
	}

	function edit(id){
		$('form').attr('action', '/admin/dosen/ubah');
		$('#tambah_header').html("Ubah Akun Dosen");
		$form.reset();
		var data = JSON.parse($(id).html());
		$('label[for="password"]').html('Password <sup class="text-danger">*Optional</sup>');
		$('input[name="id_admin"]').attr('required', 'required');
		$('input[name="id_admin"]').val(data['id_admin']);
		$('input[name="nama_dsn"]').val(data['nama_dsn']);
		$('input[name="email"]').val(data['email']);
		$('input[name="noHP"]').val(data['noHP']);
		$('input[name="kelas"]').val(data['kelas']);
		$('input[name="password"]').removeAttr('required');
		$('select[name="hak_akses"]').val(data['hak_akses']);

		if(data['hak_akses'] == 'admin')
			$('input[name="kelas"]').attr('disabled', 'disabled');
	}

	function hapus(id){
		$('#hapus_data').attr('href', '/admin/dosen/hapus/' + id);
	}

	$(document).ready(function(){
  	$('select[name="hak_akses"]').change(function(){
			if($('form').attr('action').substr(-4) != "ubah")
	  		if($(this).val() == 'admin'){
	  			$('input[name="kelas"]').attr('disabled', 'disabled');
	  			$('input[name="kelas"]').removeAttr('required');
	  		}
	  		else{
	  			$('input[name="kelas"]').attr('required', 'required');
	  			$('input[name="kelas"]').removeAttr('disabled');
	  		}
  	})

		$('#table_data').DataTable({
		  "responsive": true,
		  "autoWidth": false,
		  "language": {
			  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
		  },
		  "fnDrawCallback": function (oSettings){
			$('.dataTables_filter').each(function () {
				if($('#btn_add').length < 1)
				$(this).append('<button class="btn btn-primary btn-sm  mb-1 ms-3" id="btn_add" data-bs-toggle="modal" data-bs-target="#tambah" onclick="tambah()">Tambah</button>');
			});
		  }
		});
	});
</script>

@endsection