<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\ProgramSubject;
use App\Models\ProgramStructure;
use App\Models\ApprovalRequest;

class CreateStructure extends Component
{

    public $structureId;
    public array $structure = [];
    public $semIndex;
    public $title = '';
    public $remarks = '';
    public $studenttype = false; // New property to track if it's for international students
    public array $selectedSubjects = [];
    public $isOpen = false;


    public function mount(){
       $this->structure = session('draft_structure', []); 
       $this->title = session('draft_title', '');
    }

    public function render()
    {
        return view('livewire.create-structure', [ 
            'subjects' => Subject::where('is_active', true)->get(),
            ])->layout('layouts.app'); 
    }


        public function openModal($semselect) {
    $this->isOpen = true;
    $this->semIndex = $semselect;
  
    }


    public function addSemester() {
        $this-> structure[] = ['subs' => []];
        $this->persistToSession();
    }


    public function addSelectedSubjects(){
       foreach ($this->selectedSubjects as $id) {
        // 1. Check dulu dalam structure (array) kita, subjek ni dah ada ke belum
        // Kita guna collect() supaya senang nak cari dalam nested array
        $alreadyExists = collect($this->structure[$this->semIndex]['subs'])
                            ->contains('id', $id);

        if (!$alreadyExists) {
            $subject = Subject::find($id);
            
            if ($subject) {
                // 2. KITA SIMPAN DATA RINGKAS SAHAJA (Bukan Objek Penuh)
                // Ini supaya bila refresh, session tak pening
                $this->structure[$this->semIndex]['subs'][] = [
                    'id' => $subject->id,
                    'subject_name' => $subject->subject_name,
                    'subject_code' => $subject->subject_code,
                    'credit_hours' => $subject->credit_hours,
                ];
            }
        }
    }
        
        $this->persistToSession();
        $this->selectedSubjects = [];
        $this->isOpen = false;
        
    }

    public function closeModal(){
        $this->isOpen = false;
    }
    
    public function removeFromTable($semselect, $id) 
    {
        $subs = $this-> structure[$semselect]['subs'];

        foreach($subs as $i => $sub){
            if ($sub['id'] == $id){
                unset($subs[$i]);
            }
        }     

            $this-> structure[$semselect]['subs'] = array_values($subs);
            $this->persistToSession();
    }

    public function persistToSession()
    {
        session([
            'draft_structure' => $this->structure,
            'draft_title' => $this->title
        ]);
    }

    public function store() {

    $this->validate([
        'title' => ['required','string','max:255'],
       'structure' => ['required', 'array'],
         ]);

         $finalTitle = $this->title;
         if ($this->studenttype) {
            $finalTitle .= '(International)';
            }else {
            $finalTitle .='(Local)';
            }

           $struct = DB::transaction( function () use ($finalTitle) {
            $newStruct = ProgramStructure::create([
            'program_structure_name' => $finalTitle,
            'program_id' => 1,
            'created_by' => auth()->id(),
        ]);

        foreach($this->structure as $index => $semester) {
            $semesterNum = $index + 1;
            foreach ($semester['subs'] as $subject){
            ProgramSubject::create([
            'program_structure_id'=> $newStruct->id,
            'semester_number' => $semesterNum,
            'subject_id' => $subject['id'],
            'created_by' => auth()->id(),
            ]); 
            }
        } return $newStruct;
            });

        $this->structureId = $struct->id;

        session()->flash('message','Structure successfully saved');

    }
      
    public function moveUp($index) {
        if ($index == 0) return; // Tak boleh move up kalau dah kat atas

        $temp = $this->structure[$index - 1];
        $this->structure[$index - 1] = $this->structure[$index];
        $this->structure[$index] = $temp;

        $this->persistToSession();
    }

    public function moveDown($index) {
        if ($index == count($this->structure) - 1) return; // Tak boleh move down kalau dah kat bawah

        $temp = $this->structure[$index + 1];
        $this->structure[$index + 1] = $this->structure[$index];
        $this->structure[$index] = $temp;

        $this->persistToSession();
    }

    public function submit() {

    if (!$this->structureId) {
        session()->flash('error', 'Sila tekan "Save" dahulu sebelum Submit.');
        return;
    }

    $this->validate([
            'remarks' => ['nullable','string','max:255'],
        ]);


        DB::transaction(function() {
        $programStructure = ProgramStructure::findOrFail($this->structureId);
        $programStructure->update([ 'status' => 'Pending' ]);

        ApprovalRequest::create([
            'program_structure_id' => $this->structureId,
            'status' => 'Pending',
            'requested_by' => auth()->id(),
            'remarks' => $this->remarks,
        ]);

        });
        
        
        session()->forget(['draft_structure', 'draft_title']);
        session()->flash('message', "Successfully submitted for review");
    }

}
