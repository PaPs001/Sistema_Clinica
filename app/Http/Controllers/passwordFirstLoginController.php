<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class passwordFirstLoginController extends Controller
{
    //
    public function actualizarPasswordInicial(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = $request->password;
        $user->status = 'active';
        $user->save();

        return redirect()->route('dashboard.paciente')->with('success','Contraseña actualizada');
    }
}
