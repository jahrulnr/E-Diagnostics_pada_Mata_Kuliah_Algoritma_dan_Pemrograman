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

	@media (min-width: 768px) {
		.mt-md-3-custom {
			margin-top: 2.3rem !important;
		}
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
	<h1 class="my-4">Hasil Tes</h1>
	<div class="row">
		<div class="col-12 col-md-8">
			<table class="table table-bordered" id="table_data">
				<thead>
					<tr>
						<th>No.</th>
						<th>Materi</th>
						<th>Nilai</th>
					</tr>
				</thead>
				<tbody><?php $i = 1; ?>
				@foreach($hasil as $h)
					<tr>
						<td class="text-center">{{ $i++ }}.</td>
						<td>{{ $h->judul_materi }}</td>
						<td class="text-center">{{ $h->nilai_akhir }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-12 col-md-4 mt-md-3-custom">
			<table class="table table-bordered">
				<tr>
					<th>Total Nilai</th>
					<td class="text-center">{{ round($nilai->total, 2) }}</td>
				</tr>
				<tr>
					<th>Rata-Rata Nilai</th>
					<td class="text-center">{{ round($nilai->rata_rata, 2) }}</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#table_data').DataTable();
</script>
@endsection