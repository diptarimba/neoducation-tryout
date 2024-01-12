<?php

namespace App\Http\Controllers;

use App\Models\RoleHome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);

    }
    public function login()
    {
        return view('page.auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        $auth = Auth::attempt($credentials);
        $roleHome = Cache::remember('role-home', now()->addHours(24), function () {
            $dataRaw = RoleHome::get();
            $data = $dataRaw->pluck('home', 'name')->toArray();
            return $data;
        });
        if ($auth) {
            $request->session()->regenerate();
            $role = Auth::user()->getRoleNames()->first();
            if (array_key_exists($role, $roleHome)) {
                return redirect()->route($roleHome[$role])->with('success', 'Login successfully');
            }
            return $this->logout();
        } else {
            return redirect()->route('login.index')->with('error', 'Username or password is incorrect');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        return redirect()->route('login.index');
    }


}
