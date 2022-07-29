@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<!-- Plugin -->
<style>
	/* DataTables */
	@import url('/vendor/datatables/css/dataTables.bootstrap5.min.css');
	@import url('/vendor/datatables/css/responsive.bootstrap5.min.css');
</style>
<!-- DataTables -->
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/datatables/js/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables/js/responsive.bootstrap5.min.js"></script>

<div class="container-fluid px-4">
	<h1 class="my-4">Daftar Mahasiswa</h1>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="table_data">
				<thead>
					<th>No.</th>
					<th>NPM</th>
					<th>Nama</th>
					<th>Kelas</th>
					<th>Email</th>
				</thead>
				<tbody><?php $i = 1; ?>
				@foreach($data as $d)
					<tr>
						<td align="center">{{ $i++ }}.</td>
						<td>{{ $d->npm }}</td>
						<td>{{ $d->nama_mhs }}</td>
						<td>{{ $d->kelas }}</td>
						<td>
							{{ $d->email }}
							<span style="cursor: pointer;" onclick="window.open('mailto:{{ $d->email }}', 'mail')" class="fas fa-external-link-alt fa-sm"></span>
						</td>
					</tr>
      			@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="d-none" id="inp_kelas">
	Kelas: 
	<select name="kelas" class="form-select form-select-sm d-inline-block w-auto" onchange="change_kelas()">
		<option selected value="semua">Semua Kelas</option>
		@foreach($kelas as $data)
		<option value="{{ $data->kelas }}">{{ $data->kelas }}</option>
		@endforeach
	</select>
</div>

<script type="text/javascript">
	var table;

	function inp_kelas(){
		$('#opt_kelas').html($('#inp_kelas').html());
	}

	function change_kelas(){
		table.draw();
	}

	$(document).ready(function(){
  	var hash = window.location.hash;
  	if(hash == '#berhasil_disimpan'){
  		toastr.success('Data berhasil disimpan');
  	}
  	else if(hash == '#gagal_disimpan'){
  		toastr.error('Data gagal disimpan');
  	}
  	else if(hash == '#berhasil_dihapus'){
  		toastr.success('Data berhasil dihapus');
  	}
  	else if(hash == '#gagal_dihapus'){
  		toastr.error('Data gagal dihapus');
  	}

		table = $('#table_data').DataTable({
		  "responsive": true,
		  "autoWidth": false,
		  "language": {
			  url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
		  },
		  "fnDrawCallback": function (oSettings){
			$('.dataTables_filter').each(function () {
				if($('#opt_kelas').length < 1)
				$(this).append(' <label id="opt_kelas">'
					+ '<script>inp_kelas();<\/script>'
					+ '</label>');
			});
		  }
		});

		$.fn.dataTable.ext.search.push(function( settings, data, dataIndex ) {
				var kelas = data[3];
				var inp_kelas = $('[name="kelas"]').val();

				if(kelas == inp_kelas || 'semua' == inp_kelas)
					return true;

	      return false;
    });
	});
</script>

@endsection