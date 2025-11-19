<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\usersType;
use Illuminate\Support\Facades\Auth;

class rolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!Auth::check()){
            return redirect('/');
        }

        $user = Auth::user();

        $rolesMap = [
            'admin' => usersType::ROLE_ADMIN,
            'medic' => usersType::ROLE_MEDIC,
            'patient' => usersType::ROLE_PATIENT,
            'receptionist' => usersType::ROLE_RECEPTIONIST,
            'nurse' => usersType::ROLE_NURSE,
        ];

        if (!isset($rolesMap[$role])) {
            abort(500, "Rol '$role' no está definido en RoleMiddleware.");
        }

        if ($user->typeUser_id != $rolesMap[$role]) {
            return redirect()->route('login')->with('error', 'No tienes permiso para acceder.');
        }

        return $next($request);
    }
}
