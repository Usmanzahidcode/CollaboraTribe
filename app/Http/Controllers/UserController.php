<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Jobs\RenewEmailTokenJob;
use App\Jobs\ResetPasswordMailJob;
use App\Mail\WelcomeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.manageusers', ['users' => User::all()]);
    }

    public function store(RegistrationRequest $request)
    {
        $fileName = time() . '_profile_pic_' . $request->profile_picture->getClientOriginalName();
        $request->file('profile_picture')->storeAs('public/userData/profile_pictures', $fileName);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'github' => $request->input('github'),
            'password' => $request->input('password'),
            'bio' => $request->input('bio'),
            'profile_picture' => $fileName,
            'email_verification_token' => Str::random(32),
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            Mail::to($user->email)->send(new WelcomeMail([
                'name' => $user->name,
                'email' => $user->email,
                'link' => route('verify.email', ['token' => $user->email_verification_token]),
            ]));

            $request->session()->regenerate();
            return redirect()->intended(route('user.manage'));
        }

        return redirect()->route('user.manage', $user);
    }

    public function create()
    {
        return view('auth.signup');
    }

    public function signIn()
    {
        return view('auth.signin');
    }

    public function handleLogin(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('user.manage'));
        }

        return redirect()->route('users.signin')->with('signin-error', 'true');
    }

    public function signOut()
    {
        Auth::logout();
        return redirect()->route('users.signin')->with('signout-success', 'true');
    }

    public function manageAccount($tab = 'none')
    {
        return view('profile', ['user' => Auth::user(), 'tab' => $tab]);
    }

    public function show(string $id)
    {
        return view('user-profile', ['user' => User::findOrFail($id)]);
    }

    public function adminBan(Request $request, string $id)
    {
        $user = User::find($id);
        $user->status = ($request->input('submit') == 'Ban') ? 'banned' : 'active';

        if ($user->status == 'banned') {
            $user->projects()->whereIn('status', ['inactive', 'active'])->update(['status' => 'aborted']);
        }

        $user->save();
        return redirect()->back();
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        // If the profile picture is given
        if ($request->hasFile('profile_picture')) {
            Storage::delete('public/userData/profile_pictures/' . $user->profile_picture);
            $name = time() . '_profile_pic_' . $request->profile_picture->getClientOriginalName();
            $request->file('profile_picture')->storeAs('public/userData/profile_pictures/', $name);
        } else {
            $name = $user->profile_picture;
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'bio' => $request->input('bio'),
            'profile_picture' => $name,
        ]);

        return redirect()->route('user.manage', ['user' => $user->id]);
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8',
        ]);

        if (Hash::check($request->input('old_password'), Auth::user()->password)) {
            Auth::user()->update(['password' => Hash::make($validatedData['new_password'])]);
            return redirect()->route('user.manage')->with(['password_change_success' => 'true', 'tab' => 'pass']);
        }

        return redirect()->route('user.manage')->with(['password_change_failed' => 'true', 'tab' => 'pass']);
    }

    public function verifyEmail(string $token)
    {
        $user = User::where('email_verification_token', $token)->first();
        $message = $user ? ($user->email_verified_at ? 'Email already verified' : 'Email has been successfully verified!') : 'expired';

        if ($user && !$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->save();
        }

        return redirect()->route('user.manage')->with('email_status', $message);
    }

    public function regenerateEmailToken(string $id)
    {
        $user = User::find($id);
        $user->update(['email_verification_token' => Str::random(32)]);

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'link' => route('verify.email', ['token' => $user->email_verification_token])
        ];

        dispatch(new RenewEmailTokenJob($data, $user->email));
        return redirect()->back();
    }

    public function passwordReset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', Rule::exists('users', 'email')],
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if ($user && $user->reset_password_token_at && strtotime($user->reset_password_token_at) > time() - 3600) {
            return 'Too many password reset requests!';
        }

        $token = Str::random(32);
        $user->update([
            'reset_password_token' => $token,
            'reset_password_token_at' => Carbon::now(),
        ]);

        dispatch(new ResetPasswordMailJob([
            'name' => $user->name,
            'email' => $user->email,
            'link' => route('reset.form', ['token' => $token]),
        ], $user->email));

        return 'Email with the reset form link has been sent!';
    }

    public function passwordResetForm(string $token)
    {
        $user = User::where('reset_password_token', $token)->first();
        if (!$user) return 'Token Expired';

        return view('auth.password_reset_update_form', ['email' => $user->email]);
    }

    public function passwordResetUpdate(Request $request, string $email)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::where('email', $email)->update(['password' => Hash::make($request->input('password'))]);
        return view('auth.signin', ['password_reset' => 'true']);
    }
}
