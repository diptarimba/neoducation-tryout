<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SubjectTestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserTestController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\SubjectTestController as UserSubjectTestController;
use App\Http\Controllers\User\UserTestController as UserUserTestController;
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

        Route::resource('user', UserController::class);

        Route::resource('subject/test.u', UserTestController::class, [
            'names' => 'test.user'
        ])
        ->parameter('test', 'subjectTest');
        Route::resource('subject/test.q', QuestionController::class, [
            'names' => 'test.question'
        ])->parameter('test', 'subjectTest')->parameter('q', 'question');
        Route::resource('subject/test', SubjectTestController::class)->parameter('test', 'subjectTest');
        Route::resource('subject', SubjectController::class);
        Route::resource('admin', AdminController::class)->parameter('admin', 'user');
    });

    Route::prefix('user')->as('user.')->middleware(['role:user', 'auth'])->group(function () {
        Route::get('dashboard', [UserHomeController::class, 'index'])->name('dashboard');

        // unroll test with code
        Route::get('subject/test/enroll', [UserSubjectTestController::class, 'index_enroll'])->name('test.enroll.index');
        Route::post('subject/test/enroll', [UserSubjectTestController::class, 'store_enroll'])->name('test.enroll.store');

        // start landing page & start test
        Route::get('subject/test/{userTest}/start', [UserUserTestController::class, 'ready_test'])->name('test.start.index');
        Route::post('subject/test/{userTest}/start', [UserUserTestController::class, 'start_test'])->name('test.start.store');

        // the test
        Route::get('subject/test/{userTest}/show', [UserUserTestController::class, 'show_test'])->name('test.start.show');
        Route::post('subject/test/{userTest}/store', [UserUserTestController::class, 'store_test'])->name('test.end.store');

        // finish test
        Route::get('subject/test/{subjectTest}/finish', [UserSubjectTestController::class, 'finish_test'])->name('test.classement');
        Route::resource('subject/test', UserSubjectTestController::class)->parameter('test', 'subjectTest');
    });

    Route::get('logout', [LoginRegisterController::class, 'logout'])->name('logout');
});
