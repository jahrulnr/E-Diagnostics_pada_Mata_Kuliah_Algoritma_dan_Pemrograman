<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSS -->
	<link href="{{ asset('') }}/css/styles.css" rel="stylesheet" />
	<style type="text/css">
		a {
			text-decoration: none;
		}
	</style>
</head>
<body style="background-color: #f7f7f9;">
	<table class="table table-bordered table-responsive" style="background-color: #f7f7f9;">
		<thead>
			<tr>
				<th>Judul Materi</th>
				<th style="width: 40%;">Download</th>
			</tr>
		</thead>
		<tbody><?php $i = 1; ?>
		@foreach($materi as $m)
			<tr>
				<td>{{ $m->judul_materi }}</td>
				<td>
				@if($files[$m->id_materi] != null)
					@for($f = 0; $f < count($files[$m->id_materi]); $f++)
						<div class="col-12 mb-1">
							<a href="{{ asset('') }}files/materi/{{ basename($files[$m->id_materi][$f]) }}" class=" mb-1 d-block">
							{{ substr(basename($files[$m->id_materi][$f]), strpos(basename($files[$m->id_materi][$f]), "- ")+2) }}
							</a>
						</div>
					@endfor
				@else
					-
				@endif
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</body>
</html>