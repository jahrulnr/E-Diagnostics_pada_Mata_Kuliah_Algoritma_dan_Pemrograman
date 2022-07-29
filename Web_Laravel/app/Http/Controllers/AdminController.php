<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport; 
use App\Imports\MahasiswaImport;
use App\Helpers\customConfig;

class AdminController extends Controller {

	public function __construct(){
	    $this->middleware(function ($request, $next) {
	        if(session('is_admin')){
	        	$db = DB::table('admin')->where('id_admin', session('id'))->first();
	        	if(!$db){
	        		$request->session()->flush();
	        		return redirect('/');
	        	}
	        }
	        else
	        	return redirect('/');

	        return $next($request);
    	});
	}

	function dashboard(){
		$cpu = "Tidak didukung";
		$ram = "Tidak didukung";
		$uptime = "Tidak didukung";
		if(function_exists('shell_exec')){
			if(function_exists('sys_getloadavg')){
				$exec_loads = sys_getloadavg();
				$exec_cores = trim(shell_exec("grep '^processor' /proc/cpuinfo|wc -l"));
				$cpu = round($exec_loads[1]/($exec_cores + 1)*100, 0) . '%';
			}

			if(shell_exec('free')){
				$exec_free = explode("\n", trim(shell_exec('free')));
				$get_mem = preg_split("/[\s]+/", $exec_free[1]);
				$mem = number_format(round($get_mem[2]/1024/1024, 2), 2) . '/' . number_format(round($get_mem[1]/1024/1024, 2), 2);
				$exec_uptime = preg_split("/[\s]+/", trim(shell_exec('uptime')));
				$uptime = $exec_uptime[2] . ' Days';
			}
		}

	    return view('admin.dashboard', [
	    	'cpu'	  => $cpu,
	    	'ram'	  => $ram,
	    	'uptime'  => $uptime
	    ]);
	}

	function importExel(Request $data){

		$student_email = "student.uir.ac.id";
		$file = $data->excel->move('../temp', gmdate("d-m-Y H.i.s", time()+3600*7) . ".xlsx");
		$data = Excel::toCollection(new DataImport, $file);

		$dataDosen = $dataMahasiswa = [];
		foreach($data[0] as $i => $v){
			if($i > 1){
				if( $v[0] != null && 
					DB::table('admin')
						->where('email', strtolower($v[1]))
						->doesntExist()
				){
					$noHP = substr($v[2], 0, 2) == '08' ?
						$v[2] : "08" . $v[2];
					$data = [
						'nama_dsn'  => $v[0],
						'email'	    => $v[1],
						'noHP' 	    => $noHP,
						'password'  => bcrypt($v[4]),
						'hak_akses'	=> 'dosen'
					];

					$id = DB::table('admin')->insertGetId($data);
					$dataDosen[] = $data;

					$data_kelas = [];
					preg_match_all("/[a-zA-Z]/", strtoupper($v[3]), $kelas);
					$kelas[0] = array_unique($kelas[0]);
					foreach($kelas[0] as $kls){
						$data_kelas[] = [
							'id_admin' => $id,
							'kelas'	   => $kls
						];
					}
					
					if(!empty($data_kelas))
						DB::table('kelas')
							->insert($data_kelas);
				}

				if($v[6] != null &&
					customConfig::npm_validation($v[6]) !== false &&
					customConfig::studentmail_validation($v[8]) &&
					DB::table('mahasiswa')
						->where('npm', $v[6])
						->doesntExist()
				){
					$kelas = DB::table('kelas')
						->where('kelas', strtoupper($v[9]))
						->first()->id_kelas;
					$data = [
			            'npm' 	   => $v[6],
			            'nama_mhs' => $v[7],
			            'email'    => $v[8],
			            'id_kelas' => $kelas,
			            'password' => bcrypt($v[10])
					];
					$db = DB::table('mahasiswa')->insert($data);
					$dataMahasiswa[] = $data;
				}
			}
		}

		// return [$dataDosen, $dataMahasiswa];
		return back()->with('success', [count($dataDosen), count($dataMahasiswa)]);
	}

	function dosen(){
		$admin = DB::table('admin')
			->select([
				'admin.id_admin','email','nama_dsn','hak_akses', 'noHP'
			])
			->orderBy('hak_akses', 'asc')
			->orderBy('nama_dsn', 'asc')
			->get();

		$temp = [];
		foreach($admin as $adm){
			$kelas = DB::table('kelas')
				->select(DB::raw("group_concat(kelas SEPARATOR ',') as kelas"))
				->where('id_admin', $adm->id_admin)
				->orderBy('kelas')
				->first();
			$adm->kelas = $kelas->kelas;
			$temp[] = $adm;  
		}

		return view('admin.dosen', [ 
			'data'	=> $temp
		]);
	}

	function tambah_dosen(Request $request){
		if(DB::table('admin')->where('email', strtolower($request->email))->doesntExist()){
			$id = DB::table('admin')->insertGetId([
				'nama_dsn'	=> $request->nama_dsn,
				'email'		=> strtolower($request->email),
				'noHP'		=> $request->noHP,
				'password'	=> bcrypt($request->password),
				'hak_akses'	=> $request->hak_akses
			]);

			$data_kelas = [];
			preg_match_all("/[a-zA-Z]/", strtoupper($request->kelas), $kelas);
			$kelas[0] = array_unique($kelas[0]);
			foreach($kelas[0] as $kls){
				$data_kelas[] = [
					'id_admin' => $id,
					'kelas'	   => $kls
				];
			}
			
			if(!empty($data_kelas))
				DB::table('kelas')
					->insert($data_kelas);

			return redirect('/admin/dosen#berhasil_disimpan');
		}

		else
			return redirect('/admin/dosen#email_telah_digunakan');
	}

	function ubah_dosen(Request $request){
		$data = [
				'nama_dsn'	=> $request->nama_dsn,
				'email'		=> strtolower($request->email),
				'noHP'		=> $request->noHP,
				'hak_akses'	=> $request->hak_akses
			];
		if(!empty($request->password))
			$data['password'] = bcrypt($request->password);

		DB::table('admin')
			->where('id_admin', $request->id_admin)
			->update($data);

		// String ke array untuk kelas
		preg_match_all("/[a-zA-Z]/", strtoupper($request->kelas), $kelas);
		$db_kelas = DB::table('kelas')
			->select(DB::raw('GROUP_CONCAT(kelas) as kelas'))
			->where('id_admin', $request->id_admin)
			->first();

		// return explode(',', $db_kelas->kelas);
		$kls_temp = [];
		$db_kelas = explode(',', $db_kelas->kelas);
		$kelas_merge = array_merge($db_kelas, $kelas[0]);
		$kelas_merge = array_unique($kelas_merge);
		foreach ($kelas_merge as $kls) {
			$exist = DB::table('kelas')
						->where('id_admin', $request->id_admin)
						->where('kelas', $kls)
						->exists();
			if(!$exist and in_array($kls, $kelas[0])){
				DB::table('kelas')->insert([
					'id_admin' => $request->id_admin,
					'kelas'	   => $kls
					]);
			}
			elseif($exist and !in_array($kls, $kelas[0])){
				DB::table('kelas')
					->where('id_admin', $request->id_admin)
					->where('kelas', $kls)
					->delete();
			}
			// else
			// 	$kls_temp[] = [$kls, 'skip'];
		}

		return redirect('/admin/dosen#berhasil_diubah');
	}

	function hapus_dosen($id){
		$db = false;
		if($id != session('id_admin'))
			$db = DB::table('admin')->where('id_admin', $id)->delete();

		if(!$db)
			return redirect('/admin/dosen#gagal_dihapus');
		return redirect('/admin/dosen#berhasil_dihapus');
	}

	function mahasiswa(){
		$db = DB::table('mahasiswa')
			->select(['npm','email','nama_mhs','kelas.id_kelas','kelas.kelas'])
			->join('kelas', 'kelas.id_kelas', 'mahasiswa.id_kelas')
			->get();

		$kelas = DB::table('kelas')
			->join('admin', 'admin.id_admin', 'kelas.id_admin')
			->orderBy('kelas', 'asc')
			->orderBy('nama_dsn', 'asc')
			->get();

		return view('admin.mahasiswa', [ 
			'data'	=> $db,
			'kelas' => $kelas
		]);
	}

	function tambah_mahasiswa(Request $request){
		$db = false;
		$npm_valid = customConfig::npm_validation($request->npm);

		if(!customConfig::studentmail_validation($request->email))
			return redirect('/admin/mahasiswa#email_tidak_valid');
		elseif($npm_valid === false)
			return redirect('/admin/mahasiswa#npm_tidak_valid');
		elseif(DB::table('mahasiswa')->where('npm', $request->npm)->doesntExist())
			$db = DB::table('mahasiswa')->insert([
				'npm'	=> $npm_valid,
				'nama_mhs'	=> $request->nama_mhs,
				'email'		=> strtolower($request->email),
				'password'	=> bcrypt($request->password),
				'id_kelas'	=> $request->kelas
			]);

		if(!$db)
			return redirect('/admin/mahasiswa#gagal_disimpan');
		return redirect('/admin/mahasiswa#berhasil_disimpan');
	}

	function ubah_mahasiswa(Request $request){
		$data = [
				'nama_mhs'	=> $request->nama_mhs,
				'email'		=> strtolower($request->email),
				'id_kelas'	=> $request->kelas
			];
		if(!empty($request->password))
			$data['password'] = bcrypt($request->password);

		$db = false;
		if(!customConfig::studentmail_validation($request->email))
			return redirect('/admin/mahasiswa#email_tidak_valid');
		else
			$db = DB::table('mahasiswa')
				->where('npm', $request->npm)
				->update($data);

		if(!$db)
			return redirect('/admin/mahasiswa#gagal_diubah');
		return redirect('/admin/mahasiswa#berhasil_diubah');
	}

	function hapus_mahasiswa($id){
		$db = DB::table('mahasiswa')->where('npm', $id)->delete();

		if(!$db)
			return redirect('/admin/mahasiswa#gagal_dihapus');
		return redirect('/admin/mahasiswa#berhasil_dihapus');
	}

	function materi(){
		$db = DB::table('materi')
			->select('*')
			->orderBy('pertemuan', 'asc')
			->get();

		return view('admin.materi', [ 
			'data'	=> $db,
			'i'		=> 1 
		]);
	}

	function tambah_materi(Request $request){
		$db = DB::table('materi')->insert([
			'judul_materi'	=> $request->judul_materi,
			'pertemuan'		=> $request->pertemuan
		]);

		if(!$db)
			return redirect('/admin/materi#gagal_disimpan');
		return redirect('/admin/materi#berhasil_disimpan');		
	}

	function ubah_materi(Request $request){
		$data = [
				'judul_materi'	=> $request->judul_materi,
				'pertemuan'		=> $request->pertemuan
			];

		$db = DB::table('materi')
			->where('id_materi', $request->id_materi)
			->update($data);

		if(!$db)
			return redirect('/admin/materi#gagal_diubah');
		return redirect('/admin/materi#berhasil_diubah');
	}

	function hapus_materi($id){
		$db = false;

		try {
			$db = DB::table('materi')->where('id_materi', $id)->delete();

			if(!$db)
				return redirect('/admin/materi#gagal_dihapus');
		}
		catch(\Illuminate\Database\QueryException $ex){ 
		  return $ex->getMessage(); 
		}

		return redirect('/admin/materi#berhasil_dihapus');
		
	}

}

?>