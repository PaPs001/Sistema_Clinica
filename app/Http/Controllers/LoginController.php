<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\UserModel;
use App\Models\usersType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    public function LoginRequest(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if($user->status === 'inactive'){
                return redirect()->route('password.primeravez');
            }
            $routes = [
                usersType::ROLE_ADMIN => 'dashboardAdmin',
                usersType::ROLE_MEDIC => 'registro-expediente',
                usersType::ROLE_PATIENT => 'dashboard.paciente',
                usersType::ROLE_RECEPTIONIST => 'dashboardRecepcionista',
                usersType::ROLE_NURSE => 'dashboardEnfermera',
            ];

            return redirect()->route($routes[$user->typeUser_id] ?? 'login');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
