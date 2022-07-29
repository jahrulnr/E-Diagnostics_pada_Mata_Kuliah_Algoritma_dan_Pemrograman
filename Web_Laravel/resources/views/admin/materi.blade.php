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
	<h1 class="my-4">Kelola Materi</h1>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="table_data">
				<thead>
					<th>No.</th>
					<th>Judul Materi</th>
					<th>Pertemuan</th>
					<th>Aksi</th>
				</thead>
				<tbody>
				@foreach($data as $d)
					<tr>
						<td align="center">{{ $i++ }}.</td>
						<td>{{ $d->judul_materi }}</td>
						<td align="center">{{ $d->pertemuan }}</td>
						<td align="center">
							<data id="data-{{ $d->id_materi }}" class="d-none">{{ json_encode($d) }}</data>
							<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah" onclick="edit('#data-{{ $d->id_materi}}')">
								<span class="fas fa-pencil-alt"></span>
							</button>
							<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus('{{ $d->id_materi}}')">
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
        <h5 class="modal-title" id="tambah_header">Tambah Materi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" name="id_materi">
        <div class="form-input mb-3">
        	<label>Judul Materi</label>
        	<input type="text" name="judul_materi" class="form-control" placeholder="Contoh Materi" required>
        </div>
        <div class="form-input mb-3">
        	<label>Pertemuan</label>
        	<input type="number" name="pertemuan" class="form-control" min="1" placeholder="16" required>
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
           Hapus Materi
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	Yakin menghapus materi ini?<br/>
      	<small class="text-danger">
      		* Menghapus materi akan menghapus semua data yang terkait. (Ex. Soal, Jawaban, Diagnosis, dll.)
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
		$('form').attr('action', '/admin/materi/tambah');
		$('#tambah_header').html("Tambah Akun Materi");
		$form.reset();
	}

	function edit(id){
		$('form').attr('action', '/admin/materi/ubah');
		$('#tambah_header').html("Ubah Akun Materi");
		$form.reset();
		var data = JSON.parse($(id).html());
		$('input[name="id_materi"]').val(data['id_materi']);
		$('input[name="judul_materi"]').val(data['judul_materi']);
		$('input[name="pertemuan"]').val(data['pertemuan']);
	}

	function hapus(id){
		$('#hapus_data').attr('href', '/admin/materi/hapus/' + id);
	}

	$(document).ready(function(){
  	// var hash = window.location.hash;
  	// if(hash == '#berhasil_disimpan'){
  	// 	toastr.success('Data berhasil disimpan');
  	// }
  	// else if(hash == '#gagal_disimpan'){
  	// 	toastr.error('Data gagal disimpan');
  	// }
  	// else if(hash == '#berhasil_diubah'){
  	// 	toastr.success('Data berhasil diubah');
  	// }
  	// else if(hash == '#gagal_diubah'){
  	// 	toastr.error('Data gagal diubah');
  	// }
  	// else if(hash == '#berhasil_dihapus'){
  	// 	toastr.success('Data berhasil dihapus');
  	// }
  	// else if(hash == '#gagal_dihapus'){
  	// 	toastr.error('Data gagal dihapus');
  	// }

		$('#table_data').DataTable({
		  "responsive": true,
		  "autoWidth": false,
		  "language": {
			  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
		  },
		  "fnDrawCallback": function (oSettings){
			$('.dataTables_filter').each(function () {
				if($('#btn_add').length < 1)
				$(this).append('<button class="btn btn-primary btn-sm" id="btn_add" data-bs-toggle="modal" data-bs-target="#tambah" onclick="tambah()">Tambah</button>');
			});
		  }
		});
	});
</script>

@endsection