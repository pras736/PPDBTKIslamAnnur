<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalimuridController extends Controller
{
    /**
     * Display the wali murid dashboard.
     */
    public function index(Request $request)
    {
        // Prefer real authenticated user if available
        $authUser = null;
        try { $authUser = $request->user(); } catch (\Throwable $e) { $authUser = null; }

        if ($authUser) {
            $user = $authUser;
        } else {
            // Fallback: check demo session (set by demo login)
            $sessionUser = $request->session()->get('walimurid_user');
            if ($sessionUser) {
                // Cast to object for view compatibility
                $user = (object) $sessionUser;
            } else {
                // Final fallback: anonymous demo user
                $user = (object) [
                    'name' => 'Wali Murid Demo',
                    'email' => 'demo@local',
                ];
            }
        }

        return view('walimurid.dashboard', compact('user'));
    }
}
