<?php


namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $elections = Election::all();
        $selectedElection = $request->query('election_id');


        $candidates = Candidate::with('election')
            ->when($selectedElection, function ($query, $electionId) {
                return $query->where('election_id', $electionId);
            })
            ->latest()
            ->simplePaginate(3);

        return view('candidates.index', compact('candidates', 'selectedElection', 'elections'));
    }


    public function create()
    {
        $elections = Election::all();
        return view('candidates.create', compact('elections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'election_id' => 'required|exists:elections,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Candidate::create($validated);

        return redirect()->back()->with('success', 'Kandidat berhasil ditambahkan.');
    }


    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'election_id' => 'required|exists:elections,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $candidate->update($validated);

        return redirect()->back()->with('success', 'Kandidat berhasil diperbarui.');
    }

        public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->back()->with('success', 'Kandidat berhasil dihapus.');
    }
}
