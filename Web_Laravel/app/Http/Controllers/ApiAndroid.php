<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiAndroid extends Controller {

	function test(Request $request){
		$f = fopen(__DIR__."/../test.txt", 'w');
		fwrite($f, json_encode($request->all()));
		fclose($f);
		return $request->all();
	}

	function login(Request $data){
		$output = [];
		$user = strtolower($data->post('npm'));
        $status = DB::table('mahasiswa')->where('npm', $user)->first();
        if($status != null && Hash::check($data->post('password'), $status->password)){
        	return (object) [
        		'_token' => md5($data->post('npm') . "@" . $status->email),
        		'nama'	 => $status->nama_mhs,
        		'status' => 'success'
        	];
        }else{
        	return (object) [
        		'status' => 'fail'
        	];
        }
	}

	function materi(){
		$materi = DB::table('materi')
			->orderBy('pertemuan', 'asc')
			->get();

		return $materi;
	}

	function download_materi($token){
		$data = DB::table('mahasiswa')
			->select([
				'id_kelas'
			])->where(DB::raw("md5(concat(npm, '@', email))"), $token);

		if($data->doesntExist()){
			return (object) [
				'status' => "fail"
			];
		}

		$materi = DB::table('materi')
			->groupBy('judul_materi')
			->orderBy('pertemuan', 'asc')
			->get();

		$id_kelas = $data->first()->id_kelas;
		$id_dosen = DB::table('kelas')
			->select('id_admin')
			->where('kelas.id_kelas', $id_kelas)
			->first();

		if($id_dosen != null)
			foreach($materi as $m){
				$files[$m->id_materi] = glob(public_path("files/materi/{$m->id_materi}_".$id_dosen->id_admin." - *"));
				sort($files[$m->id_materi]);
			}
		else $files = [];

		// return (object) $files;
		return view('android.download_materi', [
			'materi' => $materi,
			'files'  => $files
		]);
	}

	function materi2($token){
		$data = DB::table('mahasiswa')
			->select([
				'npm'
			])->where(DB::raw("md5(concat(npm, '@', email))"), $token);

		if($data->doesntExist()){
			$materi = DB::table('materi')
				->orderBy('pertemuan', 'asc')
				->get();

			return $materi;
		}

		$npm = $data->first()->npm;
		$materi = DB::table('materi')
			->select([
				'materi.*',
				DB::raw("if(soal.id_soal, '1', '0') as soal_exists"),
				DB::raw("if(jawaban.npm, '1', '0') as jawaban_exists")
			])
			->leftJoin('soal', 'materi.id_materi', 'soal.id_materi')
			->leftJoin('jawaban', function($join) use($npm){
				$join->on('soal.id_soal', 'jawaban.id_soal');
				$join->on('jawaban.npm', DB::raw($npm));
			})
			->groupBy('materi.id_materi')
			->orderBy('pertemuan', 'asc')
			->get();

		return $materi;
	}

	function soal($id_materi, $token){
		$data = DB::table('mahasiswa')
			->select([
				'npm'
			])->where(DB::raw("md5(concat(npm, '@', email))"), $token);

		if($data->doesntExist())
			return null;

		$soal = DB::table('soal')
		->select(['id_soal', 'soal', 'bobot'])
		->where('id_materi', $id_materi)
		->inRandomOrder()
		->get();

		return $soal;
	}

	function simpan_jawaban($token, Request $request){
		$data = DB::table('mahasiswa')
			->select([
				'npm'
			])->where(DB::raw("md5(concat(npm, '@', email))"), $token);

		if($data->doesntExist() || $request->data == null)
			return null;

		$npm = $data->first()->npm;
		$data_jawaban = json_decode($request->data);

		$data = [];
		foreach($data_jawaban as $d){
			$data[] = [
				"npm" => $npm,
				"id_soal" => $d->id_soal,
				"jawaban_mhs" => $d->jawaban
			];
		}

		$save = DB::table('jawaban')
			->insert($data);

		return (Object) [
			"status" => $save ? "success" : "fail"
		];
	}

	function hasil_tes($token){
		$data = DB::table('mahasiswa')
			->select([
				'npm'
			])->where(DB::raw("md5(concat(npm, '@', email))"), $token);

		if($data->doesntExist())
			return null;

		$npm = $data->first()->npm;
		$hasil = DB::table('materi')
			->leftJoin('nilai', function($join) use($npm){
				$join->on('nilai.id_materi', 'materi.id_materi');
				$join->where('npm', $npm);
			})
			->get();

		$nilai = DB::table('nilai')
			->select([
				DB::raw("SUM(nilai_akhir) as total"),
				DB::raw("AVG(nilai_akhir) as rata_rata")
			])
			->where('npm', $npm)
			->first();

		return view("android.hasilTes", [
			'hasil' => $hasil,
			'nilai' => $nilai
		]);
	}

	function profil($token){
		$data = DB::table('mahasiswa')
			->select([
				'mahasiswa.*',
				'kelas.kelas'
			])
			->leftJoin('kelas', 'mahasiswa.id_kelas', 'kelas.id_kelas')
			->where(DB::raw("md5(concat(npm, '@', email))"), $token);
		if($data->exists()){
			$data = $data->first();
			$data->status = 'success';
			unset($data->id_kelas);
			unset($data->password);
			return $data;
		}
		else{
			return (Object) [
				'status' => 'fail'
			];
		}
	}

	function simpan_profil($token, Request $request){
		$data = DB::table('mahasiswa')
			->select('npm')
			->where(DB::raw("md5(concat(npm, '@', email))"), $token);

		if($data->doesntExist()){
			return (Object) [
				'status' => 'fail'
			];
		}

		$execute = true;
		$output = [];
		$npm = $data->first()->npm;
		$data = [
			'email' => $request->email
		];

		if(!filter_var($request->email, FILTER_VALIDATE_EMAIL )){
			$output['email'] = "fail";
			$execute = false;
		}
		else if(!empty($request->password) && strlen($request->password) < 5
				|| $npm == '173510428'){
			$output['password'] = "fail";
			$execute = false;
		}
		else if(!empty($request->password) && strlen($request->password) > 4)
			$data['password'] = bcrypt($request->password);

		if($execute == true){
			DB::table('mahasiswa')
				->where('npm', $npm)
				->update($data);
			$output['status'] = 'success';
			$output['_token'] = md5($npm ."@". $request->email);
		}else{
			$output['status'] = 'fail';
		}

		return (Object) $output;
	}

}