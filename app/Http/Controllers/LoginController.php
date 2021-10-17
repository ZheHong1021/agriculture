<?php
/*
|--------------------------------------------------------------------------
| LoginController
|--------------------------------------------------------------------------
|
| 負責登入/登出處理
*/

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function show()
    {
    	return view('login');
    }
    public function login(Request $request)
    {
    	$input = $request->all();
    	$rules = ['acc'=>'required',
	              'password'=>'required'];
	    $validator = Validator::make($input, $rules);
	    if($validator->passes()){
	    	if (Auth::attempt(['acc' => $request->acc, 'password' => $request->password])) {
	            //return Auth::user()->authority;
                if(Auth::user()->authority == 4){
                    Auth::logout();
                    return Redirect::to('login');
                }
                return redirect()->intended('/');
	        }
	        return Redirect::to('login')
                ->withErrors('帳號或密碼錯誤');
        }
        return Redirect::to('login')
                ->withErrors($validator);
        
    }
    public function logout()
    {
    	Auth::logout();
    	return Redirect::to('login');
    }
}
