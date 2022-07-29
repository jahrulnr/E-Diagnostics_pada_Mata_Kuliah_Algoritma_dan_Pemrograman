@section('admin')
<a class="nav-link" href="/admin/dosen">
    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
    Dosen
</a>
<a class="nav-link" href="/admin/mahasiswa">
    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
    Mahasiswa
</a>
<a class="nav-link" href="/admin/materi">
    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
    Materi
</a>
@endsection

@section('dosen')
<a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#c_materi" aria-expanded="true" aria-controls="c_materi">
    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
        Kelola Materi dan Soal
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse show" id="c_materi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav">
        <a class="nav-link" href="/dosen/materi">Materi dan Soal</a>
        <a class="nav-link" href="/dosen/materi/penilaian">Jawaban Mahasiswa</a>
    </nav>
</div>
<a class="nav-link" href="/dosen/mahasiswa">
    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
    Mahasiswa
</a>
<a class="nav-link" href="/dosen/diagnostics">
    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
    Diagnosis
</a>
@endsection

@section('mahasiswa')
<a class="nav-link" href="/mahasiswa/materi">
    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
    Materi
</a>
<a class="nav-link" href="/mahasiswa/hasil_tes">
    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
    Hasil Tes
</a>
@endsection
