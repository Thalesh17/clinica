<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    protected $redirectTo = '/consulta/informativo';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//    protected function authenticated(Request $request)
//    {
//        $email = $request->input('email');
//        $password = $request->input('password');
//
//        if(validateLogin(['PACIENTE'])){
//
//            $paciente = Paciente::where('user_id', Auth::user()->id)->first();
//            $request->session()->put('paciente', $paciente);
//        }else{
//            $medico = Paciente::where('user_id', Auth::user()->id)->first();
//            $request->session()->put('paciente', $medico);
//        }
//
//        \Auth::user()->swap();
//    }
}
