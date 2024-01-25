<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectTest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $student = User::role('user')->count();
        $subject = Subject::count();
        $testAll = SubjectTest::count();
        $testOnGoing = SubjectTest::where('start_at', '<', Carbon::now())->where('end_at', '>', Carbon::now())->count();
        $testEnded = SubjectTest::where('end_at', '<', Carbon::now())->count();
        $testIncoming = SubjectTest::where('start_at', '>', Carbon::now())->count();
        return view('page.admin-dashboard.home.index', compact('student', 'subject', 'testAll', 'testOnGoing', 'testEnded', 'testIncoming'));
    }
}
