<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            //$request->session()->regenerate();

            $user = Auth::user();
            // Redirect based on user role

            if ($user->role == 'superadmin') {
                return redirect('/superadmin/dashboard')->with('success', 'Login berhasil sebagai Superadmin!');
            } elseif ($user->role == 'skpd') {
                return redirect('/skpd/dashboard')->with('success', 'Login berhasil sebagai SKPD!');
            } elseif ($user->role == 'kadis') {
                return redirect('/kadis/dashboard')->with('success', 'Login berhasil sebagai Kadis!');
            } elseif ($user->role == 'bpkpad') {
                return redirect('/bpkpad/dashboard')->with('success', 'Login berhasil sebagai BPKPAD!');
            }

            // Default fallback
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password yang dimasukkan salah.',
        ])->withInput($request->only('username', 'remember'));
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Show the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }
}
