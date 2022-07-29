<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSS -->
	<link href="{{ asset('') }}/css/styles.css" rel="stylesheet" />
</head>
<body style="background-color: #f7f7f9;">
	<table class="table table-bordered table-responsive" style="background-color: #f7f7f9;">
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
				<td class="text-center">{{ $h->nilai_akhir == null ? "-" : $h->nilai_akhir }}</td>
			</tr>
		@endforeach
			<tr>
				<th colspan="2">Total nilai</th>
				<td class="text-center">{{ round($nilai->total, 2) }}</td>
			</tr>
			<tr>
				<th colspan="2">Rata-Rata</th>
				<td class="text-center">{{ round($nilai->rata_rata, 2) }}</td>
			</tr>
		</tbody>
	</table>
</body>
</html>