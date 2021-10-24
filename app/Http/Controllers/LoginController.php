<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }
    public function authView()
    {
        return view("auth.auth");
    }
    public function loginAttempt(Request $request)
    {

        $islogin = Auth::attempt($request->only("email", "password"));
        return redirect("/");
    }
    public function register(Request $request)
    {

        User::create([
            "type" => $request->type,
            "fullname" => $request->name,
            "email" => $request->emailAdress,
            "password" => Hash::make($request->password),

        ]);
        return redirect("/login");
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login");
    }
}
