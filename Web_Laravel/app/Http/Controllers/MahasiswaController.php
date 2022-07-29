<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
 
class MahasiswaController extends Controller {

	public function __construct(){
	    $this->middleware(function ($request, $next) {
	        if(session('is_mahasiswa')){
	        	$db = DB::table('mahasiswa')->where('npm', session('id'))->first();
	        	if(!$db){
	        		$request->session()->flush();
	        		return redirect('/#login_gagal');
	        	}
	        }
	        else
	        	return redirect('/');

	        return $next($request);
    	});
	}

	function dashboard(){
	    return view('mahasiswa.dashboard');
	}

	function materi(){
		$db = DB::table('materi')
			->select(['materi.*', 'jawaban.id_jawaban'])
			->leftJoin('soal', 'materi.id_materi', 'soal.id_materi')
			->leftJoin('jawaban', function($join){
				$join->on('soal.id_soal', 'jawaban.id_soal');
				$join->where('jawaban.npm', session('id'));
			})
			->groupBy('judul_materi')
			->orderBy('pertemuan', 'asc')
			->get();

		$id_dosen = DB::table('kelas')
			->select('id_admin')
			->where('kelas.id_kelas', session('id_kelas'))
			->first();

		if($id_dosen != null)
			foreach($db as $m){
				$files[$m->id_materi] = glob(public_path("files/materi/{$m->id_materi}_".$id_dosen->id_admin." - *"));
				sort($files[$m->id_materi]);
			}
		else $files = [];

		return view('mahasiswa.materi', [
			'data' => $db,
			'files' => $files
		]);
	}

	function form_tes($id_materi){
		// Data Materi
		$data['materi'] = DB::table('materi')
			->where('id_materi', $id_materi)
			->first();

		$data['dosen'] = DB::table('admin')
			->select('admin.*')
			->join('kelas', 'kelas.id_admin', 'admin.id_admin')
			->where('kelas.id_kelas', session('id_kelas'))
			->first();
		// return $data['dosen'];

		// Data soal dan jawaban
		$data['soal'] = DB::table('soal')
			->select(['soal.*', 'jawaban.jawaban_mhs'])
			->leftJoin('jawaban', function($join){
				$join->on('soal.id_soal', 'jawaban.id_soal');
				$join->where('jawaban.npm', session('id'));
			})
			->where('id_admin', $data['dosen']->id_admin)
			->where('id_materi', $id_materi);
		$data['soal_count'] = $data['soal']->count();
		$data['soal'] = $data['soal']->get();
		// return $data['soal'];
		
		// cek jawaban
		$data['jawaban'] = false;
		foreach($data['soal'] as $soal) {
			if($soal->jawaban_mhs != null){
				$data['jawaban'] = true;
				break;
			}
		}

		return view('mahasiswa.materi_tes', $data);
	}

	function submit_soal($id_materi, Request $request){
		$data = []; 
		$db = null;
		foreach($request->jawaban as $id => $jawaban){
			if( 
			DB::table('jawaban')
				->where('npm', session('id'))
				->where('id_soal', $id)
				->doesntExist()
			)

			$data[] = [
				'npm'	  	  => session('id'),
				'id_soal' 	  => $id,
				'jawaban_mhs' => $jawaban
			];
		}

		if(!empty($data))
			$db = DB::table('jawaban')
				->insert($data);

		if(!$db)
			return redirect(url()->previous() . '#gagal_disimpan');

		return redirect(url()->previous() . '#berhasil_disimpan');
	}

	function profil(){
		$data = DB::table('mahasiswa')
			->select([
				'mahasiswa.*',
				'kelas.kelas',
				'admin.nama_dsn'
			])
			->where('npm', session('id'))
			->leftJoin('kelas', 'mahasiswa.id_kelas', 'kelas.id_kelas')
			->leftJoin('admin', 'kelas.id_admin', 'admin.id_admin')
			->first();

		return view('mahasiswa.profil', [
			'data' => $data
		]);
	}

	function ubah_profil(Request $req){
		$data = [
			'nama_mhs'  => $req->nama_mhs,
			'email' 	=> $req->email
		];

		if($req->password != null){
			if(strlen($req->password) < 5){
				return redirect(url()->previous() . '#password_kurang');
			}else{
				$data['password'] = bcrypt($req->password);
			}
		}

		$db = DB::table('mahasiswa')
			->where('npm', session('id'))
			->update($data);

		if($db){
			session('nama', $data['nama_mhs']);
			return redirect(url()->previous() . '#berhasil_disimpan');
		}
		else
			return redirect(url()->previous() . '#gagal_disimpan');
	}

	function hasil_tes(){
		$hasil = DB::table('nilai')
			->join('materi', 'nilai.id_materi', 'materi.id_materi')
			->where('npm', session('id'))
			->get();

		$nilai = DB::table('nilai')
			->select([
				DB::raw("SUM(nilai_akhir) as total"),
				DB::raw("AVG(nilai_akhir) as rata_rata")
			])
			->where('npm', session('id'))
			->first();

		return view('mahasiswa.hasil_tes', [
			'hasil' => $hasil,
			'nilai' => $nilai
		]);
	}
}