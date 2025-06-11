<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voter;

class LoginController extends Controller
{
    public function showLoginToken()
    {
        if (session()->has('voter')) {
            return redirect()->route('voting.index');
        }

        return view('voter.login');
    }

    public function logintoken(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $voter = Voter::where('token', $request->token)->first();

        if (!$voter) {
            return back()->withErrors(['token' => 'Token tidak ditemukan']);
        }

        // Simpan voter ke session
        session(['voter' => $voter]);

        return redirect()->route('voting.index');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('voter'); 
        return redirect('/voting'); 
    }
}
