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
        $totalPending = ProgramStructure::where('status','draft')->count();
        $totalApproved = ProgramStructure::where('status','approved')->count();
        $drafts= ProgramStructure::all();
        $role = auth()->user()->roles()->value('role');




        return view('hop.dashboard', compact(
            'drafts',
            'totalPending', 
            'totalApproved',
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

    /**
     * Display the specified resource.
     */
    public function show(rc $rc)
    {
        //
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
}
