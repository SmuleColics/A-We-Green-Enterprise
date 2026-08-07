<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordCodeMail;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ─────────────────────────────────────────
    // REGISTER (public — clients only)
    // ─────────────────────────────────────────

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_CLIENT,
            'contact_number' => $request->contact_number,
            'status' => 'active',
        ]);

        Client::create([
            'user_id' => $user->id,
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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

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

        if (! User::where('email', $request->email)->exists()) {
            return back()
                ->with('error', "We couldn't find an account with that email address.")
                ->withInput();
        }

        $code = random_int(100000, 999999);

        DB::table('password_reset_codes')->updateOrInsert(
            ['email' => $request->email],
            ['code' => Hash::make($code), 'created_at' => now()]
        );

        Mail::to($request->email)->send(new ResetPasswordCodeMail((string) $code));

        return redirect()->route('reset-password', ['email' => $request->email])
            ->with('success', 'A 6-digit reset code has been sent to your email.');
    }

    // ─────────────────────────────────────────
    // RESET PASSWORD
    // ─────────────────────────────────────────

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_codes')->where('email', $request->email)->first();

        if (! $record || ! Hash::check($request->code, $record->code)) {
            return back()->withErrors(['code' => 'Invalid reset code.'])->withInput();
        }

        if (now()->diffInMinutes($record->created_at) > 15) {
            return back()->withErrors(['code' => 'This code has expired. Please request a new one.'])->withInput();
        }

        $user = User::where('email', $request->email)->first();

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        DB::table('password_reset_codes')->where('email', $request->email)->delete();

        ActivityLogController::log(
            'Auth',
            'Updated',
            "Password reset successfully for {$user->full_name}.",
            $user->id,
            $user->full_name
        );

        return redirect()->route('sign-in')
            ->with('success', 'Your password has been reset successfully. Please log in.');
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
