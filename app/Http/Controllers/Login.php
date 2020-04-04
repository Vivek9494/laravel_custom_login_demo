<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Users;
use Session;

class Login extends Controller
{
    function index(){
        return view('index');
    }

    function login(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|min:3'
        ]);
      
        
        if ($user = Users::where('email', $request->email)->first()) {
            if ($request->password == $user->password) {
                Session::put('admin', $user);
                return redirect(route('dashboard.index'));
            }else{
                return back()->with('error', 'Invalid Credentials');
            }
        }else{
            return back()->with('error', 'Invalid Credentials');
        }
    }

    function logout(Request $request){
        $request->session()->forget('admin');

        return redirect(route('index'));
    }
}
