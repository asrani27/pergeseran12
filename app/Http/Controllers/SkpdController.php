<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SkpdController extends Controller
{
    /**
     * Display a listing of the SKPD.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all SKPD data with relationships
        $data = Skpd::with(['user', 'kepala'])->get();

        return view('superadmin.skpd.index', compact('data'));
    }

    /**
     * Create account for SKPD
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function createAkun($id)
    {
        $skpd = Skpd::findOrFail($id);

        if ($skpd->user) {
            return redirect()->route('skpd.index')->with('error', 'Akun SKPD sudah ada');
        }

        // Generate new random password
        $newPassword = 'passwordskpd';

        // Create user account
        $cleanKodeSkpd = preg_replace('/\s+/', '', $skpd->kode_skpd);
        $user = User::create([
            'name' => $skpd->nama,
            'email' => $cleanKodeSkpd . '@skpd.local',
            'username' => $cleanKodeSkpd,
            'password' => Hash::make($newPassword),
            'role' => 'skpd',
        ]);

        // Update SKPD with user_id
        $skpd->update(['user_id' => $user->id]);

        return redirect()->route('skpd.index')->with('success', "Akun SKPD berhasil dibuat. Username: {$cleanKodeSkpd}, Password: {$newPassword}");
    }

    /**
     * Reset SKPD account
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function resetAkun($id)
    {
        $skpd = Skpd::findOrFail($id);

        if ($skpd->user) {
            // Generate new random password
            $newPassword = 'passwordskpd';

            // Update user password
            $skpd->user->update([
                'password' => bcrypt($newPassword)
            ]);

            return redirect()->route('skpd.index')->with('success', "Akun SKPD berhasil direset. Password baru: {$newPassword}");
        }

        return redirect()->route('skpd.index')->with('error', 'Akun SKPD tidak ditemukan');
    }

    /**
     * Create account for SKPD kepala
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function createKepalaAkun($id)
    {
        $skpd = Skpd::findOrFail($id);

        if ($skpd->kepala) {
            return redirect()->route('skpd.index')->with('error', 'Akun Pimpinan SKPD sudah ada');
        }

        // Generate new random password
        $newPassword = 'passwordpimpinan';

        // Create user account
        $cleanKodeSkpd = preg_replace('/\s+/', '', $skpd->kode_skpd);
        $user = User::create([
            'name' => 'Pimpinan ' . $skpd->nama,
            'email' => 'pimpinan_' . $cleanKodeSkpd . '@skpd.local',
            'username' => 'pimpinan_' . $cleanKodeSkpd,
            'password' => Hash::make($newPassword),
            'role' => 'pimpinan',
        ]);

        // Update SKPD with kepala_id
        $skpd->update(['kepala_id' => $user->id]);

        return redirect()->route('skpd.index')->with('success', "Akun Pimpinan SKPD berhasil dibuat. Username: pimpinan_{$cleanKodeSkpd}, Password: {$newPassword}");
    }

    /**
     * Reset SKPD kepala account
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function resetKepalaAkun($id)
    {
        $skpd = Skpd::findOrFail($id);

        if ($skpd->kepala) {
            // Generate new random password
            $newPassword = 'passwordpimpinan';

            // Update user password
            $skpd->kepala->update([
                'password' => bcrypt($newPassword)
            ]);

            return redirect()->route('skpd.index')->with('success', "Akun Pimpinan SKPD berhasil direset. Password baru: {$newPassword}");
        }

        return redirect()->route('skpd.index')->with('error', 'Akun Pimpinan SKPD tidak ditemukan');
    }
}
