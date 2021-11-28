<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
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
        try {
            $islogin = Auth::attempt($request->only("email", "password"));
            if ($islogin) {
                return response()->json(["success" => true]);
            }
            return  response()->json(["success" => false, "message" => "Invalid email or password"]);
        } catch (Exception $er) {
            return  response()->json(["success" => false, "message" => "An error occur, please try again"]);
        }
    }
    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                "type" => "required",
                "name" => "required",
                "emailAddress" => "required",
                "password" => "required|confirmed",

            ]);
            $getExisitingUser = User::where("email", $request->emailAddress)->first();
            if (!empty($getExisitingUser)) {
                return response()->json(['success' => false, "message" => "Account is already registered"]);
            }

            $created =   User::create([
                "type" => $request->type,
                "fullname" => $request->name,
                "email" => $request->emailAddress,
                "password" => Hash::make($request->password),

            ]);

            Auth::attempt([
                "email" => $request->emailAddress,
                "password" => $request->password,
            ]);

            return response()->json(['success' => !empty($created), "message" => !empty($created) ? "You've Successfully registered" : "Please specify valid input fields."]);
        } catch (Exception $er) {
            return response()->json(['success' => false, "message" => "An Error occur, Please try again.", $er]);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login");
    }
}
