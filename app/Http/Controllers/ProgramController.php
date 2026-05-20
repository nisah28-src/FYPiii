<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
{
    public function index()
{
    $programs = Program::all();
    $userRole = auth()->user()->roles()->first()?->role;

    return view('programs.index', compact('programs', 'userRole'));
}

public function store(Request $request)
{
    $request->validate([
        'program_name' => 'required',
    ]);

    Program::create($request->all());

    return redirect()->back()->with('success', 'Program added successfully!');
}
}
