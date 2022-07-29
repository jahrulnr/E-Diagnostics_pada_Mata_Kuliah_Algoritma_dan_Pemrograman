<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller {

	public function __construct(){
	    $this->middleware(function ($request, $next) {
	        return $next($request);
    	});
	}

	function test(Request $req){

		$subject = "Reset Password";
		$msg = [
			'title' => "Reset Password",
			'body'	=> asset("reset/token/bd63204313950003c6251e38ad00108d")
		];

		// send email
		\Mail::to('jahrulnr@gmail.com')->send(new \App\Mail\eMail($subject, $msg));

		return $msg;
	}

	function testToken($npm, $email){

	}

	function mailView($mail, Request $request){

		// test link : http://localhost:8000/mailView/bd63204313950003c6251e38ad00108d
		$data = DB::table('mahasiswa')
			->select([
				DB::raw("md5(concat(npm, '@', email)) as token"),
				'npm',
				'email',
				'nama_mhs'
			])
			->having('token', $mail)
			->first();

		$subject = "Reset Password";
		$msg = [
			'title' => "Reset Password",
			'body'	=> asset("reset/token/" . $data->token)
		];

		return view('mail.reset_pass',[ 'msg' => $msg ]);
	}
}

?>