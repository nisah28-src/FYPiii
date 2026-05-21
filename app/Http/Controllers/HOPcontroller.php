<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStructure;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class HOPController extends Controller
{
     public function index()
    {

        $userId = auth()->id();
        $totalPending = ProgramStructure::where('status','pending')->where('created_by', $userId)->count();
        $totalApproved = ProgramStructure::where('status','approved')->where('created_by', $userId)->count();
        $totalDraft = ProgramStructure::where('status','draft')->where('created_by', $userId)->count();

        $drafts= ProgramStructure::where('created_by', $userId)->orderBy('status')->get()->groupBy('status');

        $role = auth()->user()->load('roles');



        return view('hop.dashboard', compact(
            'drafts',
            'totalPending', 
            'totalApproved',
            'totalDraft',
            'role',
            
            ));

    }

   
    public function destroy($id)
    {
        $structure = ProgramStructure::findOrFail($id);

        $structure->programSubjects()->delete();
        $structure->delete();

        return redirect()->route('hop.dashboard')->with('success', 'Structure successfully deleted');
    }


    public function duplicate($id)
{
    return DB::transaction(function () use ($id) {
    // 1. Cari structure asal
    $original = ProgramStructure::with('programSubjects')->findOrFail($id);

    // 2. Replicate structure tu (copy properties dia)
    $newStructure = $original->replicate();

    $name = $original->program_structure_name;

   $base = preg_replace('/\s*\(V\d+\)$/', '', $name);

// 2. Cari yang paling latest
$latest = ProgramStructure::where('program_structure_name', 'LIKE', $base . ' (V%')
    ->orderBy('program_structure_name', 'desc')
    ->first();

if ($latest) {
    // Regex fix: pastikan cari (V123) dan ambil digit di dalam
    if (preg_match('/\(V(\d+)\)$/', $latest->program_structure_name, $matches)) {
        $version = (int)$matches[1] + 1;
    } else {
        $version = 2;
    }
} else {
    $version = 2;
}

$newTitle = $base . " (V{$version})";
    
    // 3. Ubah nama sikit supaya user tak pening
    $newStructure->program_structure_name = $newTitle;
    $newStructure->status = 'draft';
    $newStructure->version = $version;
    $newStructure->save();

    // 4. Copy semua subjek-subjek dia
    foreach ($original->programSubjects as $subject) {
        $newSubject = $subject->replicate();
        $newSubject->program_structure_id = $newStructure->id; // Link kan ke structure baru
        $newSubject->save();
    }
        return redirect()->route('hop.dashboard')->with('success', 'Structure successfully duplicated');
});
}
}
