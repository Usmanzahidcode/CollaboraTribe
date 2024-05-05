<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AlreadyLoggedIn;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsLoggedIn;
use App\Http\Middleware\IsLoggedInAndActive;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/user/sign-out', [UserController::class, 'signOut'])->name('users.signout')->middleware(IsLoggedIn::class);
Route::post('/users/authenticate', [UserController::class, 'signin_submit'])->name('users.signin_submit')->middleware(AlreadyLoggedIn::class);
Route::get('/user/sign-in', [UserController::class, 'signIn'])->name('users.signin')->middleware(AlreadyLoggedIn::class);


Route::middleware(IsLoggedInAndActive::class)->group(function () {
    // User Routes
    Route::resource('users', UserController::class);
    Route::post('/change/password', [UserController::class, 'changePassword'])->name('user.changepassword');

    // Project Routes
    Route::resource('projects', ProjectController::class);

    // Project Archive
    Route::get('project/archive', [ProjectController::class, 'archive'])->name('projects.archive');

    //Comments routes
    Route::resource('comments', CommentController::class);
    Route::post('/comments/{project}', [CommentController::class, 'store'])->name('comments.store');

    //Project status updates
    Route::post('/project/change-status/{project}', [ProjectController::class, 'changeStatus'])->name('project.changestatus');

    Route::middleware(IsAdmin::class)->group(function () {
        Route::resource('users', UserController::class)->only(['index']);
        Route::post('/project/admin-approval/{project}', [ProjectController::class, 'changeStatusByAdmin'])->name('project.adminapproval');
        Route::get('admin/projects/manage', [ProjectController::class, 'manageProjects'])->name('projects.manage');
        Route::post('admin/users/{user}/ban', [UserController::class, 'adminBan'])->name('users.ban');
    });


});

Route::resource('users', UserController::class)->only(['create', 'store'])->middleware(AlreadyLoggedIn::class);
Route::resource('posts', CommentController::class)->except(['index', 'show', 'create']);

//Manage Account
Route::get('/account/manage/', [UserController::class, 'manageAccount'])->name('user.manage')->middleware(IsLoggedIn::class);

Route::get('/verify-email/{token}', [UserController::class, 'verifyEmail'])->name('verify.email');
Route::get('/regenerate/email-token/{user}', [UserController::class, 'regenerateEmailToken'])->name('regenerate.emailtoken');

Route::get('/reset-password', function () {
    return view('auth.password_reset_form');
})->middleware(AlreadyLoggedIn::class)->name('reset.password');

Route::post('/reset-password-email-submit', [UserController::class, 'passwordReset'])
    ->middleware(AlreadyLoggedIn::class)
    ->name('reset.submit');

Route::get('/update-password/{token}', [UserController::class, 'passwordResetForm'])
    ->middleware(AlreadyLoggedIn::class)
    ->name('reset.form');

Route::post('/update-password-submit/{email}', [UserController::class, 'passwordResetUpdate'])
    ->middleware(AlreadyLoggedIn::class)
    ->name('reset.submitted');

Route::get('/404', function () {
    return view('fallback');
});
