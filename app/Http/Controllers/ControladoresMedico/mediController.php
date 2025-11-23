<?php

namespace App\Http\Controllers\ControladoresMedico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;

class mediController extends Controller
{
    //Get data para login se obtienen generos, mantenerlo en mediController
    public function GetData(){
        $generos = UserModel->genre;
        return view('LOGIN.login', compact('genre'));
    }
}
