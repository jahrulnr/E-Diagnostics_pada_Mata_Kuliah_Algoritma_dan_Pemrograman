@extends('templates.startbootstrap')
@extends('templates.sidebar')

@section('content')

<div class="container-fluid px-4">
	<h1 class="my-4">Materi</h1>
	<div class="row">
		@foreach($data as $materi)
		<a href="/dosen/materi/penilaian/{{ $materi->id_materi }}" class="col-12 col-md-4 mb-3">
			<div class="card card-body menu-materi">
				<div class="row">
					<div class="col-md-4 d-none d-md-block text-end">
						<span style="font-size: 4rem;font-weight: bolder;">{{ $materi->pertemuan }}</span>
					</div>
					<div class="col-md-8 col-12 my-auto">
							Materi<hr class="m-0" />
							{{ $materi->judul_materi }}
					</div>
				</div>
			</div>
		</a>
		@endforeach
	</div>
</div>

@endsection