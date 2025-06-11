<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Candidate;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $elections = Election::all();


        $selectedElection = $request->get('election_id');

        if ($selectedElection) {
            $elections = Election::with(['candidates.votes'])
                ->where('id', $selectedElection)
                ->get();
        } else {
            $elections = Election::with(['candidates.votes'])->get();
        }

        return view('dashboard.index', compact('elections', 'selectedElection', 'elections'));
    }
}

