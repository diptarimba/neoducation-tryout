<?php

namespace App\Http\Controllers;

use App\Models\RoleHome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->getRoleNames()->first();
        $roleHome = Cache::remember('role-home', now()->addHours(24), function () {
            $dataRaw = RoleHome::get();
            $data = $dataRaw->pluck('home', 'name')->toArray();
            return $data;
        });
        $data = [
            'url' => route('profile.store', $user->id),
            'home' => $roleHome[$role],
            'title' => 'Profile'
         ];
        return view('page.profile.me', compact('user', 'data'));
    }

    public function store(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'sometimes',
                'file' => 'max:2048|mimes:png,jpg,jpeg'
            ]);

            $password = is_null($request->password) || $request->password === '' ? $user->password : bcrypt($request->password);
            $image = $request->file('file') ? '/storage/' . $request->file('file')->storePublicly('profile') : $user->picture;

            $user->update(array_merge($request->all(), [
                'password' => $password,
                'picture' => $image
            ]));

            return redirect()->route('profile.me')->with('success', 'Profile updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

    }
}
