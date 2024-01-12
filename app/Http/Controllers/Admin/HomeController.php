<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectTest;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $student = User::role('user')->count();
        $subject = Subject::count();
        $test = SubjectTest::count();
        return view('page.admin-dashboard.home.index', compact('student', 'subject', 'test'));
    }
}
