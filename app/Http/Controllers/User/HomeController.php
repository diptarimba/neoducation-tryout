<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserTest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $userTest = UserTest::where('user_id', auth()->user()->id)->count();
        return view('page.user-dashboard.home.index', compact('userTest'));
    }
}
