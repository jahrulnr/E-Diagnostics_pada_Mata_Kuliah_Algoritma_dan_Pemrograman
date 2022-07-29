<?php

use Illuminate\Support\Facades\Route;
require_once 'apiAndroid.php';

// Test Controller for Beta Testing
Route::any('/test', 'App\Http\Controllers\TestController@test');
Route::any('/mailView/{token}', 'App\Http\Controllers\TestController@mailView');

// kontak
Route::get('/about', function(){
	return redirect('/panduan');
});
Route::get('/panduan', 'App\Http\Controllers\MainController@about');

// Login
Route::get('/', 'App\Http\Controllers\MainController@index');
Route::post('/login', 'App\Http\Controllers\MainController@verify');
Route::post('/mahasiswa/login', 'App\Http\Controllers\MainController@verify');

// Reset Password
Route::post('/reset', 'App\Http\Controllers\MainController@reset');
// -- email konfirmasi
Route::any('/reset/token/{token}', 'App\Http\Controllers\MainController@reset_verify'); 

// Logout 
Route::get('/keluar', 'App\Http\Controllers\MainController@logout');

// Admin
Route::get('/admin', 'App\Http\Controllers\AdminController@dashboard'); 
Route::post('/admin/importExcel', 'App\Http\Controllers\AdminController@importExel');

Route::get('/admin/dosen', 'App\Http\Controllers\AdminController@dosen'); 
Route::post('/admin/dosen/kelas/tambah', 'App\Http\Controllers\AdminController@tambah_kelas'); 
Route::get('/admin/dosen/kelas/hapus/{id}', 'App\Http\Controllers\AdminController@tambah_kelas'); 
Route::post('/admin/dosen/tambah', 'App\Http\Controllers\AdminController@tambah_dosen'); 
Route::post('/admin/dosen/ubah', 'App\Http\Controllers\AdminController@ubah_dosen'); 
Route::get('/admin/dosen/hapus/{id}', 'App\Http\Controllers\AdminController@hapus_dosen'); 

Route::get('/admin/mahasiswa', 'App\Http\Controllers\AdminController@mahasiswa'); 
Route::post('/admin/mahasiswa/tambah', 'App\Http\Controllers\AdminController@tambah_mahasiswa'); 
Route::post('/admin/mahasiswa/ubah', 'App\Http\Controllers\AdminController@ubah_mahasiswa'); 
Route::get('/admin/mahasiswa/hapus/{id}', 'App\Http\Controllers\AdminController@hapus_mahasiswa'); 

Route::get('/admin/materi', 'App\Http\Controllers\AdminController@materi'); 
Route::post('/admin/materi/tambah', 'App\Http\Controllers\AdminController@tambah_materi'); 
Route::post('/admin/materi/ubah', 'App\Http\Controllers\AdminController@ubah_materi'); 
Route::get('/admin/materi/hapus/{id}', 'App\Http\Controllers\AdminController@hapus_materi'); 

// Dosen
Route::get('/dosen', 'App\Http\Controllers\DosenController@dashboard'); 

// Materi
Route::get('/dosen/materi', 'App\Http\Controllers\DosenController@materi'); 
Route::get('/dosen/materi/{id_materi}', 'App\Http\Controllers\DosenController@data_materi')->where('id_materi', '[0-9]+'); 
Route::post('/dosen/materi/berkas/upload/{id_materi}', 'App\Http\Controllers\DosenController@upload_materi');
Route::get('/dosen/materi/berkas/hapus/{nama}', 'App\Http\Controllers\DosenController@hapus_materi');
Route::post('/dosen/soal/tambah', 'App\Http\Controllers\DosenController@tambah_soal'); 
Route::post('/dosen/soal/ubah', 'App\Http\Controllers\DosenController@ubah_soal'); 
Route::get('/dosen/soal/hapus/{id}', 'App\Http\Controllers\DosenController@hapus_soal'); 

// -- Penilaian Materi
Route::get('/dosen/materi/penilaian', 'App\Http\Controllers\DosenController@materi_penilaian');
Route::get('/dosen/materi/penilaian/{id_materi}', 'App\Http\Controllers\DosenController@data_jawaban');
Route::get('/dosen/materi/penilaian/kelas/{kelas}', 'App\Http\Controllers\DosenController@api_mahasiswa');
Route::get('/dosen/materi/penilaian/{id_materi}/{npm}', 'App\Http\Controllers\DosenController@api_jawaban');
Route::post('/dosen/materi/penilaian/nilai', 'App\Http\Controllers\DosenController@nilai_jawaban');

// -- Mahasiswa
Route::get('/dosen/mahasiswa', 'App\Http\Controllers\DosenController@mahasiswa'); 
Route::post('/dosen/mahasiswa/tambah', 'App\Http\Controllers\DosenController@tambah_mahasiswa'); 
Route::post('/dosen/mahasiswa/ubah', 'App\Http\Controllers\DosenController@ubah_mahasiswa'); 
Route::get('/dosen/mahasiswa/hapus/{id}', 'App\Http\Controllers\DosenController@hapus_mahasiswa'); 

// -- Diagnosis --
Route::get('/dosen/diagnostics', 'App\Http\Controllers\DosenController@diagnostics');
Route::get('/api/diagnostics/kelas/{kelas}', 'App\Http\Controllers\DosenController@diagnostics_kelas');
Route::get('/api/diagnostics/permateri/{materi}/{kelas}', 'App\Http\Controllers\DosenController@diagnostics_permateri');
Route::get('/api/diagnostics/permahasiswa/{kelas}/{npm}', 'App\Http\Controllers\DosenController@diagnostics_permahasiswa');
Route::get('/api/diagnostics/seluruh_materi/{kelas}', 'App\Http\Controllers\DosenController@diagnostics_seluruhMateri');

// -- Profil
Route::get('/dosen/profil', 'App\Http\Controllers\DosenController@profil');
Route::post('/dosen/profil/ubah', 'App\Http\Controllers\DosenController@ubah_profil');

// Mahasiswa
Route::get('/mahasiswa', 'App\Http\Controllers\MahasiswaController@dashboard');  
Route::get('/mahasiswa/materi', 'App\Http\Controllers\MahasiswaController@materi');
Route::get('/mahasiswa/materi/{id_materi}', 'App\Http\Controllers\MahasiswaController@form_tes');  
Route::post('/mahasiswa/materi/{id_materi}', 'App\Http\Controllers\MahasiswaController@submit_soal');  
Route::post('/mahasiswa/materi/{id_materi}/{id_dosen}', 'App\Http\Controllers\MahasiswaController@api_soal');  
Route::get('/mahasiswa/profil', 'App\Http\Controllers\MahasiswaController@profil');  
Route::post('/mahasiswa/profil/simpan', 'App\Http\Controllers\MahasiswaController@ubah_profil');  
Route::get('/mahasiswa/hasil_tes', 'App\Http\Controllers\MahasiswaController@hasil_tes');  
