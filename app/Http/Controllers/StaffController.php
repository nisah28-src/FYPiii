<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramStructure;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalApproved = ProgramStructure::where('status','approved')->count();
        $approved= ProgramStructure::where('status','approved')->get();
        $totalProgram = Program::all()->count();
        return view('staff.dashboard', compact('totalApproved','approved','totalProgram'));
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

    /**
     * Display the specified resource.
     */
    public function show(c $c)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(c $c)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, c $c)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(c $c)
    {
        //
    }
}
