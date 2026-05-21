<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Imports\SubjectsImport;
use App\Enums\SubjectStatus;
use Illuminate\Validation\Rules\Enum;
use Maatwebsite\Excel\Facades\Excel;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $role = auth()->user()->roles()->value('role');
        $search = $request->input('search');

        $subjects = Subject::query()
        ->when($search, function($query) use ($search) {
            $query->where('subject_code', 'like', "%{$search}%")
                  ->orWhere('subject_name', 'like', "%{$search}%");
        })
        ->get()
        ->groupBy(function ($item) {
            return substr($item -> subject_code,0,4);
        } );

        return view('subject.index', compact('subjects','role'));
    }

    public function toggleStatus($id)
    {
       $subject = \App\Models\Subject::findOrFail($id);
       $subject->is_active = !$subject->is_active;
        $subject->save();

        return redirect()->route('subject.index')->with('success', 'Subject status updated successfully!');
    }  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('subject.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => ['required','string','max:255'],
            'subject_code' => ['required','string','max:255'],
            'credit_hours' => ['required','integer'],
            'category_type' => ['required',new Enum(SubjectStatus::class)],
        ]);

        $type= $request->enum('category_type',SubjectStatus::class);


        $subject = Subject::create($request->all());

        if ($request->subject_prerequisite){
            $subject->prerequisites()->sync($request->subject_prerequisite);
        }
        
        return redirect()->route('subject.index')->with('success','Subject added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
       
        return view('subject.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $subjects = Subject::where('id', '!=', $id)->get();
            
        return view('subject.edit', compact('subject', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
     

        $request->validate([
            'subject_name' => ['required','string','max:255'],
            'subject_code' => ['required','string','max:255'],
            'credit_hours' => ['required','integer'],
            'category_type' => ['required',new Enum(SubjectStatus::class)],
        ]);

        $type= $request->enum('category_type',SubjectStatus::class);


        $prereqIds = $request->input('subject_prerequisite', []);
        $cleanIds = array_values(array_unique(array_filter((array)$prereqIds)));

        $subject->update([
        'subject_name' => $request->subject_name,
        'subject_code' => $request->subject_code,
        'credit_hours' => $request->credit_hours,
        'category_type' => $request->category_type,
        'prerequisites' => json_encode($cleanIds),
    ]);
            $subject->prerequisites()->sync($cleanIds);
        
        return redirect()->route('subject.index')->with('success','Subject updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subject.index')->with('success','Subject deleted successfully!');
    }

    public function import(Request $request){
        
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new SubjectsImport, request()->file('file'));

        return back()->with('success','Subjects imported successfully.');
    }
}
