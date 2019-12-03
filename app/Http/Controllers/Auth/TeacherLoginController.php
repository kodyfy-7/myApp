<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class TeacherLoginController extends Controller
{
	public function __construct(){
		$this->middleware('guest:teacher');
	}

    public function showLoginForm(){
    	return view('auth.teacher-login');
	}
	
	public function username(){
		return username;
	}

    public function login(Request $request){
    	//Validate the form data
    	$this->validate($request, [
    		'username' => 'required', 
    		'password' => 'required|min:6'
    	]);

    	//Attempt to log the user in
    	if (Auth::guard('teacher')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
    		//If successfull, then redirect to intended location
    		return redirect()->intended(route('teacher.dashboard'));
    	}    	

    	//If unsuccessful, then redirect to login with form data
    	return redirect()->back()->withInput($request->only('username', 'remember'));
    }
}
