<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\UserModel;
use App\Models\usersType;

class LoginController extends Controller
{
    public function LoginRequest(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = UserModel::where('email', $validation['email'])->first();

        if ($user && Hash::check($validation['password'], $user->password)) {

            Session::put('user_id', $user->id);
            Session::put('first_name', $user->first_name);
            Session::put('last_name', $user->last_name);
            Session::put('typeUser_id', $user->typeUser_id);

            $user = Auth::user();
            if($user->status === 'inactive'){
                return redirect()->route('password.primeravez');
            }
            $routes = [
                usersType::ROLE_ADMIN => 'dashboardAdmin',
                usersType::ROLE_MEDIC => 'dashboardMedico',
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
