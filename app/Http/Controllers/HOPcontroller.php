<?php

namespace App\Http\Controllers;

use App\Models\ProgramStructure;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;


class HOPcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPending = ProgramStructure::where('status','pending')->count();
        $totalApproved = ProgramStructure::where('status','approved')->count();
        $totalDraft = ProgramStructure::where('status','draft')->count();
        $drafts= ProgramStructure::orderBy('status')->get()->groupBy('status');
        $role = auth()->user()->roles()->value('role');




        return view('hop.dashboard', compact(
            'drafts',
            'totalPending', 
            'totalApproved',
            'totalDraft',
            'role',
            ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    
    public function show(rc $rc)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rc $rc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, rc $rc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rc $rc)
    {
        //
    }


    public function duplicate($id)
{
    // 1. Cari structure asal
    $original = ProgramStructure::with('programSubjects')->findOrFail($id);

    // 2. Replicate structure tu (copy properties dia)
    $newStructure = $original->replicate();

    $name = $original->program_structure_name;

    $count = ProgramStructure::where('program_structure_name', 'LIKE', $name . '%')->count();
    
    // 3. Ubah nama sikit supaya user tak pening
    $newStructure->program_structure_name = $name . '(V' . ($count + 1). ')';
    $newStructure->status = 'draft'; // Reset status jadi draft
    $newStructure->save();

    // 4. Copy semua subjek-subjek dia
    foreach ($original->programSubjects as $subject) {
        $newSubject = $subject->replicate();
        $newSubject->program_structure_id = $newStructure->id; // Link kan ke structure baru
        $newSubject->save();
    }

    // Redirect ke dashboard with new doc on the list
    return redirect()->route('hop.dashboard')->with('success', 'Structure successfully duplicated');
}

}
