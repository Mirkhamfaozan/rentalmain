<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function tampilRegistrasi() {
        return view('registrasi');

    }
    function submitRegistrasi(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        dd($user);
        //return redirect()->route('login');

    }
}

function tampilLogin() {
    return view('login');

}
function submitLogin(Request $request){
    $user = new User();
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();
    dd($user);
    //return redirect()->route('login');

}
