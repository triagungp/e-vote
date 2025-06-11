<?php


namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function index()
    {
        $elections = Election::latest()->get();
        return view('elections.index', compact('elections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        Election::create($validated);
        return redirect()->back()->with('success', 'Pemilihan berhasil ditambahkan.');
    }

    public function update(Request $request, Election $election)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $election->update($validated);
        return redirect()->back()->with('success', 'Pemilihan berhasil diperbarui.');
    }

    public function destroy(Election $election)
    {
        $election->delete();
        return redirect()->back()->with('success', 'Pemilihan berhasil dihapus.');
    }
}
