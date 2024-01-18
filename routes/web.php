<?php

use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SubjectTestController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return redirect()->route('login.index');
})->middleware('guest');
Route::get('/register', function () {
    return view('page.auth.register');
})->name('register.index');
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/login', [LoginRegisterController::class, 'login'])->name('login.index');
Route::post('/authenticate', [LoginRegisterController::class, 'authenticate'])->name('login.post');

Route::middleware(['no_auth'])->group(function () {
    Route::get('me', [ProfileController::class, 'index'])->name('profile.me');
    Route::post('{user}/me', [ProfileController::class, 'store'])->name('profile.store');
    Route::prefix('admin')->as('admin.')->middleware(['role:admin', 'auth'])->group(function () {
        Route::get('dashboard', [AdminHomeController::class, 'index'])->name('dashboard');
        Route::resource('subject/test.q.a', AnswerController::class, [
            'names' => 'test.answer'
        ])
        ->parameter('test', 'subjectTest')
        ->parameter('q', 'question')
        ->parameter('a', 'answer');
        Route::resource('subject/test.q', QuestionController::class, [
            'names' => 'test.question'
        ])->parameter('test', 'subjectTest')->parameter('q', 'question');
        Route::resource('subject/test', SubjectTestController::class)->parameter('test', 'subjectTest');
        Route::resource('subject', SubjectController::class);
    });

    Route::prefix('user')->as('user.')->middleware(['role:user', 'auth'])->group(function () {
        Route::get('dashboard', [UserHomeController::class, 'index'])->name('dashboard');
    });

    Route::get('logout', [LoginRegisterController::class, 'logout'])->name('logout');
});
