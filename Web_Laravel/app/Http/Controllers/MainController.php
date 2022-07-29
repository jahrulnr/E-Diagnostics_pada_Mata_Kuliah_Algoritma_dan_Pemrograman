<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
 
class MainController extends Controller {

    function about(){
        return view('about');
    }

	function index(Request $request){
        if(session('is_admin'))
        	return redirect('/admin/');

        else if(session('is_dosen'))
        	return redirect('/dosen/');

        else if(session('is_mahasiswa'))
        	return redirect('/mahasiswa/');

        else
	        return view('login');
	}

	function verify(Request $request){
        $route = Route::getFacadeRoot()->current()->uri();
		if($route=='login'){
            $user = strtolower($request->post('email'));
            $status = DB::table('admin')->where('email', $user)->first();
            if($status != null && Hash::check($request->post('password'), $status->password)){
                $session = array(
                    'id'   => $status->id_admin,
                    'nama' => $status->nama_dsn,
                );

                if($status->hak_akses == 'admin')
                    $session['is_admin'] = true;
                else 
                    $session['is_dosen'] = true;

                session($session);
                return redirect('/');
            }else{
                return redirect('/#login_gagal');
            }
        }
        else {
            $user = strtolower($request->post('npm'));
            $status = DB::table('mahasiswa')->where('npm', $user)->first();
            if($status != null && Hash::check($request->post('password'), $status->password)){
                $session = array(
                    'is_mahasiswa' => true,
                    'id'   => $status->npm,
                    'nama' => $status->nama_mhs,
                    'id_kelas' => $status->id_kelas 
                );

                session($session);
                return redirect('/admin/');
            }else{
                return redirect('/#login_gagal');
            }
        }
	}

    function reset(Request $request){
        if(empty($request->user)) return redirect('/');

        $user = is_numeric($request->user) ?
            // Jika NPM
            DB::table('mahasiswa')
            ->where('npm', $request->user) : (
            // Jika Email
            DB::table('mahasiswa')
            ->where('email', $request->user)->exists() ? 
            // Detect 1 - Email mahasiswa
            DB::table('mahasiswa')
            ->where('email', $request->user) :
            // Detect 2 - Email dosen
            DB::table('admin')
            ->where('email', $request->user));
            
        if($user->exists()){
            $user = $user->first();
            $createToken = md5($user->email ."@". $user->password);

            $subject = "Reset Password";
            $msg = [
                'title' => "Reset Password",
                'name' => !isset($user->nama_mhs) ? $user->nama_dsn : $user->nama_mhs,
                'body'  => asset("reset/token/$createToken")
            ];

            // send email
            \Mail::to($user->email)->send(new \App\Mail\eMail($subject, $msg));
            return "<script>window.location.href='/#reset_confirm';</script>";
        }

        return "<script>window.location.href='/#account_not_found';</script>";
    }

    function reset_verify($token, Request $post){
        $token_raw = DB::raw("md5(concat(email, '@', password)) as token");
        $data = DB::table('mahasiswa')
            ->select([$token_raw, 'mahasiswa.*'])
            ->having('token', $token)->exists() ?
            DB::table('mahasiswa')
            ->select([$token_raw, 'mahasiswa.*', DB::raw("'mahasiswa' as status")])
            ->having('token', $token) :
            DB::table('admin')
            ->select([$token_raw, 'admin.*', DB::raw("'admin' as status")])
            ->having('token', $token);

        if($data->doesntExist()){
            return redirect("/");
        }

        if($post->password){
            $data = $data->first();
            $id = $data->status == "admin" ? "id_admin" : "npm";
            $w_id = $data->status == "admin" ? $data->id_admin : $data->npm;
            DB::table($data->status)
                ->where($id, $w_id)
                ->update(['password' => bcrypt($post->password)]);
            return redirect("/#reset_success");
        }
            

        return view('reset_pass');
    }

	function logout(Request $request){
		$session = array(
            'is_admin'     => null,
			'is_dosen'     => null,
			'is_mahasiswa' => null,
            'id_user'      => null,
            'nama'         => null,
            'id_kelas'     => null
        );
        session($session);
        return "<script>window.location.href='/' + window.location.hash;</script>";
	}

}