<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ─────────────────────────────────────────
    // REGISTER (public — clients only)
    // ─────────────────────────────────────────

    public function register(Request $request)
{
    $request->validate([
        'first_name'     => 'required|string|max:100',
        'last_name'      => 'required|string|max:100',
        'email'          => 'required|email|unique:users,email',
        'password'       => 'required|min:8|confirmed',
        'contact_number' => 'nullable|string|max:20',
    ]);

    $user = User::create([
        'first_name'     => $request->first_name,
        'last_name'      => $request->last_name,
        'email'          => $request->email,
        'password'       => Hash::make($request->password),
        'role'           => User::ROLE_CLIENT,
        'contact_number' => $request->contact_number,
        'status'         => 'active',
    ]);

    Client::create([
        'user_id'   => $user->id,
        'client_id' => Client::generateClientId(),
        // block, lot, street, barangay, province, city, zip_code left null —
        // filled in later via profile or assessment request
    ]);

    ActivityLogController::log(
        'Client',
        'Created',
        "New client account registered: {$user->full_name} ({$user->email}).",
        $user->id,
        $user->full_name
    );

    Auth::login($user);

    return redirect()->route('portal')
        ->with('success', "Welcome, {$user->first_name}! Your account has been created.");
}

    // ─────────────────────────────────────────
    // LOGIN
    // ─────────────────────────────────────────

    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    $remember    = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout();
            return back()->with('error', 'Your account is not yet active. Please contact the administrator.');
        }

        ActivityLogController::log(
            'Auth',
            'Login',
            "{$user->full_name} logged in successfully.",
            $user->id,
            $user->full_name
        );

        return redirect()->intended(route($this->redirectByRole($user->role)))
            ->with('success', "Welcome back, {$user->first_name}!");
    }

    return back()->with('error', 'These credentials do not match our records.')->onlyInput('email');
}

    // ─────────────────────────────────────────
    // LOGOUT
    // ─────────────────────────────────────────

    public function logout(Request $request)
    {
        $user = Auth::user();

        ActivityLogController::log(
            'Auth',
            'Logout',
            "{$user->full_name} logged out.",
            $user->id,
            $user->full_name
        );

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sign-in')->with('success', 'You have been logged out successfully.');
    }

    // ─────────────────────────────────────────
    // FORGOT PASSWORD
    // ─────────────────────────────────────────

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Password reset link has been sent to your email.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // ─────────────────────────────────────────
    // RESET PASSWORD
    // ─────────────────────────────────────────

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                ActivityLogController::log(
                    'Auth',
                    'Updated',
                    "Password reset successfully for {$user->full_name}.",
                    $user->id,
                    $user->full_name
                );
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('sign-in')
                ->with('success', 'Your password has been reset successfully. Please log in.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // ─────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────

    private function redirectByRole(string $role): string
    {
        return match ($role) {
            User::ROLE_CLIENT => 'portal',
            User::ROLE_EMPLOYEE,
            User::ROLE_SECRETARY,
            User::ROLE_ADMIN,
            User::ROLE_SUPER_ADMIN => 'dashboard',
            default => 'sign-in',
        };
    }
}