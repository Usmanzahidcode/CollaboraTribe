<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use App\Mail\RenewVerificationToken;
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

    public function signOut()
    {
        Auth::logout();
        return redirect()->route('users.signin')->with('signout-success', 'true');
    }

    public function signIn()
    {
        return view('auth.signin');
    }

    public function signin_submit(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('user.manage'));
        }

        return redirect()->route('users.signin')->with('signin-error', 'true');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.manageusers', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.signup');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'bio' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'github' => 'required|string',
            'profile_picture' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:5120',],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $name = time() . '_profile_pic_' . $request->profile_picture->getClientOriginalName();
        $request->file('profile_picture')->storeAs('public/userData/profile_pictures', $name);

        // Create the user
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->github = $request->input('github');
        $user->password = $validatedData['password'];
        $user->bio = $request->input('bio');
        $user->profile_picture = $name;

        $user->email_verification_token = Str::random(32);
        $user->save();
        $credentials = $request->only('email', 'password');

        $data2 = [
            'name' => $user->name,
            'email' => $user->email,
            'link' => route('verify.email', ['token' => $user->email_verification_token]),
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Mail::to($user->email)->send(new WelcomeMail(data1: $data2));
            return redirect()->intended(route('user.manage'));
        }

        // Redirect or return a response
        return redirect()->route('user.manage', $user);
    }

    /**
     * Display the specified resource.
     */
    public function manageAccount($tab = 'none')
    {
        $user = Auth::user();
        return view('profile', ['user' => $user, 'tab' => $tab]);
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('user-profile', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'bio' => 'required|string',
            'github' => 'required|string',
            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:5120',],
        ]);

        $user = User::find($id);

        if ($request->hasFile('profile_picture')) {
            Storage::delete('public/userData/profile_pictures/' . $user->profile_picture);
            $name = time() . '_profile_pic_' . $request->profile_picture->getClientOriginalName();
            $request->file('profile_picture')->storeAs('public/userData/profile_pictures/', $name);
        } else {
            $name = $user->profile_picture;
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->bio = $request->input('bio');
        $user->profile_picture = $name;

        $user->save();

        return redirect()->route('user.manage', ['user' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function adminBan(Request $request, string $id)
    {
        $user = User::find($id);
        if ($request->input('submit') == 'Ban') {
            $user->status = 'banned';
            $user->authoredProjects()->whereIn('status', ['inactive', 'active'])->update(['status' => 'aborted']);

        } elseif ($request->input('submit') == 'Unban') {
            $user->status = 'active';
        }

        $user->save();

        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8',
        ]);

        if (Hash::check($request->input('old_password'), Auth::user()->password)) {
            $user = Auth::user();
            $user->password = Hash::make($validatedData['new_password']);
            $user->save();

            return redirect()->route('user.manage')->with(['password_change_success' => 'true', 'tab' => 'pass']);
        } else {
            return redirect()->route('user.manage')->with(['password_change_failed' => 'true', 'tab' => 'pass']);
        }
    }

    public function verifyEmail(string $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        $message = 'Email has been successfully verified!'; // Default message

        if ($user == null) {
            $message = 'expired';
        } else {
            if ($user->email_verified_at != null) {
                $message = 'Email already verified';
            } else {
                $user->email_verified_at = now();
                $user->save();
            }
        }

        return redirect()->route('user.manage')->with('email_status', $message);
    }

    public function regenerateEmailToken(string $id)
    {
        $user = User::find($id);
        $user->email_verification_token = Str::random(32);
        $user->save();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'link' => route('verify.email', ['token' => $user->email_verification_token])
        ];

        Mail::to('gmail@gmail.com')->send(new RenewVerificationToken($data));

        return redirect()->back();
    }

    public function passwordReset(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email'),
            ],
        ]);


        $token = Str::random('32');
        $user = User::where('email', $request->input('email'))->first();

        if ($user->reset_password_token_at) {
            $tokenTimestamp = strtotime($user->reset_password_token_at); // Convert datetime to Unix timestamp
            $timeDifference = time() - $tokenTimestamp;

            // Check if the token was generated within the last hour
            if ($timeDifference < 3600) {
                dd('Too many password reset requests!');
            }
        }


        $user->reset_password_token = $token;
        $user->reset_password_token_at = Carbon::now();
        $user->save();


        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'link' => route('reset.form', ['token' => $user->reset_password_token]),
        ];

        Mail::to($user->email)->send(new PasswordReset($data));
        return 'Email with the reset form link has been sent!';
    }

    public function passwordResetForm(string $token)
    {
        $user = User::where('reset_password_token', $token)->first();
        if ($user == null) {
            dd('Token Expired');
        } else {
            return view('auth.password_reset_update_form', ['email' => $user->email]);
        }
    }

    public function passwordResetUpdate(Request $request, string $email)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);
        $password = Hash::make($request->input('password'));
        $user = User::where('email', $email)->first();
        $user->password = $password;
        $user->save();

        return view('auth.signin', ['password_reset' => 'true']);
    }
}
