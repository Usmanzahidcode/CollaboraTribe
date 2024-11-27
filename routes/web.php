<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\NotLoggedIn;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::group(['middleware' => ['unauthenticated']], function () {
    Route::post('/users/authenticate', [UserController::class, 'handleLogin'])->name('users.signin_submit');
    Route::get('/user/sign-in', [UserController::class, 'signIn'])->name('users.signin');

    // Password
    Route::get('/reset-password', function () {
        return view('auth.password_reset_form');
    })->name('reset.password');

    Route::post('/reset-password-email-submit', [UserController::class, 'passwordReset'])
        ->name('reset.submit');

    Route::get('/update-password/{token}', [UserController::class, 'passwordResetForm'])
        ->name('reset.form');

    Route::post('/update-password-submit/{email}', [UserController::class, 'passwordResetUpdate'])
        ->name('reset.submitted');
});


Route::group(['middleware' => ['authenticated', 'active', 'verified']], function () {

    Route::get('/user/sign-out', [UserController::class, 'signOut'])->name('users.signout');

    // User Routes
    Route::resource('users', UserController::class);
    Route::post('/change/password', [UserController::class, 'changePassword'])->name('user.changepassword');
    Route::get('/account/manage/', [UserController::class, 'manageAccount'])->name('user.manage');

    // Project Routes
    Route::resource('projects', ProjectController::class);
    Route::get('project/archive', [ProjectController::class, 'archive'])->name('projects.archive');
    Route::post('/project/change-status/{project}', [ProjectController::class, 'changeStatus'])->name('project.changestatus');

    //Comments routes
    Route::resource('comments', CommentController::class);
    Route::post('/comments/{project}', [CommentController::class, 'store'])->name('comments.store');

    Route::group(['middleware' => ['admin']], function () {
        Route::get('users', [UserController::class, 'index']);
        Route::post('/project/admin-approval/{project}', [ProjectController::class, 'changeStatusByAdmin'])->name('project.adminapproval');
        Route::get('admin/projects/manage', [ProjectController::class, 'manageProjects'])->name('projects.manage');
        Route::post('admin/users/{user}/ban', [UserController::class, 'adminBan'])->name('users.ban');
    });
});

Route::resource('users', UserController::class)->only(['create', 'store'])->middleware(NotLoggedIn::class);
Route::resource('posts', CommentController::class)->except(['index', 'show', 'create']);

Route::get('/verify-email/{token}', [UserController::class, 'verifyEmail'])->name('verify.email');
Route::get('/regenerate/email-token/{user}', [UserController::class, 'regenerateEmailToken'])->name('regenerate.emailtoken');


Route::get('/404', function () {
    return view('fallback');
});
