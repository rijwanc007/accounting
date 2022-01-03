<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::where('remember_token','=',null)->orderBy('id', 'DESC')->paginate(20);
        return view('home', compact('users'));
    }
    public function welcome(){
        if (Auth::user()) {
            $users = User::where('remember_token','=',null)->orderBy('id', 'DESC')->paginate(20);
            return view('home', compact('users'));
        }else{
            return view('welcome');
        }
    }
}
