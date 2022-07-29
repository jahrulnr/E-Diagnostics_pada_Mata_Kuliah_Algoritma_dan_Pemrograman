<?php

	// ex: bd63204313950003c6251e38ad00108d

	Route::any('/android/login', 'App\Http\Controllers\ApiAndroid@login');
	Route::any('/android/materi', 'App\Http\Controllers\ApiAndroid@materi');
	Route::any('android/download/materi/{token}', 'App\Http\Controllers\ApiAndroid@download_materi');
	Route::any('/android/materi/{id_materi}/soal/{token}', 'App\Http\Controllers\ApiAndroid@soal');
	Route::any('/android/materi2/{token}', 'App\Http\Controllers\ApiAndroid@materi2');
	Route::any('/android/simpan/jawaban/{token}', 'App\Http\Controllers\ApiAndroid@simpan_jawaban');
	Route::any('/android/hasil/tes/{token}', 'App\Http\Controllers\ApiAndroid@hasil_tes');
	Route::any('/android/profil/{token}', 'App\Http\Controllers\ApiAndroid@profil');
	Route::any('/android/simpan/profil/{token}', 'App\Http\Controllers\ApiAndroid@simpan_profil');

	// test Post
	Route::any('/android/test', 'App\Http\Controllers\ApiAndroid@test');

	// Global API
	Route::any('/api/kelas/{id_dosen}', 'App\Http\Controllers\MainController@getKelas')->name('getKelas');