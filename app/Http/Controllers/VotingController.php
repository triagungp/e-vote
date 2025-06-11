<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    public function index()
    {
        $voter = session('voter');

        if (!$voter) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $candidates = Candidate::where('election_id', $voter->election_id)->get();

        return view('voting.index', compact('candidates', 'voter'));
    }

    public function vote(Request $request, $id)
    {
        $voter = session('voter');
        $candidate = Candidate::findOrFail($id);

        if (!$voter) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($voter->used) {
            return redirect()->route('voting.index')->with('error', 'Anda sudah melakukan voting.');
        }

        if ($candidate->election_id !== $voter->election_id) {
            return redirect()->route('voting.index')->with('error', 'Kandidat tidak sesuai dengan pemilihan Anda.');
        }

        $now = now();
        $election = $candidate->election;
        if ($now->lt($election->start_time) || $now->gt($election->end_time)) {
            return redirect()->route('voting.index')->with('error', 'Voting tidak tersedia pada waktu ini.');
        }

        $voter->candidate_id = $candidate->id;
        $voter->used = true;
        $voter->voted_at = now();
        $voter->save();

        return redirect()->route('voting.index')->with('success', 'Terima kasih telah melakukan voting.');
    }
}
