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
            } elseif ($user->role == 'pimpinan') {
                return redirect('/pimpinan/dashboard')->with('success', 'Login berhasil sebagai Pimpinan!');
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
        // Get statistics from database
        $totalPergeseran = \App\Models\Pengajuan::count();
        $menungguVerifikasi = \App\Models\Pengajuan::where('status_bpkpad', 1)->count();
        $disetujui = \App\Models\Pengajuan::where('status_bpkpad', 2)->count();
        $ditolak = \App\Models\Pengajuan::where('status_bpkpad', 3)->count();

        // Get recent activities (last 10 pengajuan)
        $recentActivities = \App\Models\Pengajuan::with(['user', 'skpd'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get monthly data for chart (last 12 months)
        $monthlyData = \App\Models\Pengajuan::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Calculate percentage changes from previous month
        $lastMonthCount = \App\Models\Pengajuan::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $thisMonthCount = \App\Models\Pengajuan::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $totalPercentage = $lastMonthCount > 0 ? round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 0) : 0;
        
        $lastMonthApproved = \App\Models\Pengajuan::where('status_bpkpad', 2)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $thisMonthApproved = \App\Models\Pengajuan::where('status_bpkpad', 2)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $approvedPercentage = $lastMonthApproved > 0 ? round((($thisMonthApproved - $lastMonthApproved) / $lastMonthApproved) * 100, 0) : 0;
        
        $lastMonthRejected = \App\Models\Pengajuan::where('status_bpkpad', 3)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $thisMonthRejected = \App\Models\Pengajuan::where('status_bpkpad', 3)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $rejectedPercentage = $lastMonthRejected > 0 ? round((($thisMonthRejected - $lastMonthRejected) / $lastMonthRejected) * 100, 0) : 0;

        return view('superadmin.dashboard', compact(
            'totalPergeseran',
            'menungguVerifikasi',
            'disetujui',
            'ditolak',
            'recentActivities',
            'monthlyData',
            'totalPercentage',
            'approvedPercentage',
            'rejectedPercentage'
        ));
    }
}
