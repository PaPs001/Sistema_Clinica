<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\userModel;

class LoginController extends Controller
{
    public function LoginRequest(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = userModel::where('email', $validation['email'])->first();

        if ($user && Hash::check($validation['password'], $user->password)) {

            Session::put('user_id', $user->id);
            Session::put('first_name', $user->first_name);
            Session::put('last_name', $user->last_name);
            Session::put('typeUser_id', $user->typeUser_id);

            if ($user->typeUser_id == 3) {
                return redirect()->route('dashboardPaciente');
            } elseif ($user->typeUser_id == 2) {
                return redirect()->route('dashboardMedico'); 
            } else {
                return redirect()->route('login');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');

    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect('/');
    }
}
