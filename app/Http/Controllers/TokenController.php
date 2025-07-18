<?php

// app/Http/Controllers/TokenController.php
namespace App\Http\Controllers;


use App\Models\Election;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        $elections = Election::all();
        $selectedElection = $request->query('election_id');
        $status = $request->query('status'); // ambil status dari request

        $voters = Voter::with(['election', 'candidate'])
            ->when($selectedElection, function ($query, $electionId) {
                return $query->where('election_id', $electionId);
            })
            ->when($status === 'used', function ($query) {
                return $query->where('used', true);
            })
            ->when($status === 'unused', function ($query) {
                return $query->where('used', false);
            })
            ->latest()
            ->simplePaginate(10);

        return view('tokens.index', compact('elections', 'voters', 'selectedElection', 'status'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'election_id' => 'required|exists:elections,id',
            'jumlah' => 'required|integer|min:1|max:500',
        ]);

        for ($i = 0; $i < $request->jumlah; $i++) {
            Voter::create([
                'token' => Str::random(8),
                'election_id' => $request->election_id,
            ]);
        }

        return redirect()->route('tokens.index')->with('success', 'Token berhasil dibuat.');
    }
    public function destroy(Voter $voter)
    {
        $voter->delete();
        return redirect()->back()->with('success', 'Token berhasil dihapus.');
    }
}
