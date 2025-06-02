<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Table;

class AuthController extends Controller {
    //mengarah
    public function showRegister() {
        return view('auth.register');
    }
    public function showLogin() {
        // if (Auth::check()) {
        //     return redirect()->intended('admin_dashboard');
        // }

        return view('auth.login');
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            "username" => 'required|max:50|min:4|unique:users,name',
            "email" => 'required|email|unique:users,email',
            "password" => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validateNewUser = $validator->validate();

        $user = User::create([
            'name' => $validateNewUser['username'],
            'email' => $validateNewUser['email'],
            'password' => $validateNewUser['password']
        ]
        );


        if ($user->isadmin == 1) {
            Auth::login($user);
            return redirect()->route('admin')->with('sucsess', $validateNewUser['username']);
        }

        return redirect()->intended('/');
    }

    public function login(Request $request) {

        $validator_credential = Validator::make($request->all(), [ //memvalidasi input dengan rule yang telah di tentukan
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);

        if ($validator_credential->fails()) { //mengecek apakah sesuai dengan rule
            return redirect()->back()->withErrors($validator_credential)->withInput(); //jika sesuai arahkan kembali ke halaman sebelumnya 
        }

        $validate_credential = $validator_credential->validate();
        $remember = $request->has('remember');

        if (Auth::attempt($validate_credential, $remember)) { //mengecek ke database apakah sesuai dengan input form
            $request->session()->regenerate();

            if (Auth::user()->isadmin == 1) {
                return redirect()->route('admin'); //jika sesuai arahkan ke halaman admin
            }

            if (Table::where('no_meja', $request->no_meja)->exists()) {
                return redirect()->route('katalog.user', ['user' => Auth::user()->id, 'table' => $request->no_meja]);
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([  //jika tidak sesuai kembali ke halaman sebelumnya
            'email' => 'Your password, no_meja or email does not match',
            'password' => 'Your password, no_meja or email does not match',
            'no_meja' => 'Your password, no_meja or email does not match',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
