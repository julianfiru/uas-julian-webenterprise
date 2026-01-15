<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard
     */
    public function index()
    {
        // Cek apakah user sudah login
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        return view('dashboard');
    }

    /**
     * Menampilkan halaman database user
     */
    public function databaseUser()
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        return view('database_user');
    }

    /**
     * Menampilkan halaman jurnal tidur (Daily - Default)
     */
    public function jurnalDaily()
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        return view('jurnal.daily');
    }

    /**
     * Menampilkan halaman jurnal tidur (Weekly)
     */
    public function jurnalWeekly()
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        return view('jurnal.weekly');
    }

    /**
     * Menampilkan halaman jurnal tidur (Monthly)
     */
    public function jurnalMonthly()
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        return view('jurnal.monthly');
    }
}
