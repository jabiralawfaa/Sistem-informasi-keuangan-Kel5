<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect based on user role
        switch ($user->role) {
            case 'admin':
                return view('admin.dashboard');
            case 'bendahara':
                return view('bendahara.dashboard');
            case 'auditor':
                return view('auditor.dashboard');
            default:
                return view('dashboard');
        }
    }
}
