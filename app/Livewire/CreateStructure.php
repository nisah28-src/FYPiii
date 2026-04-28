<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subject;
use App\Models\ProgramSubject;
use App\Models\ProgramStructure;

class CreateStructure extends Component
{

    public $selectedYear = '';
    
    public array $structure = [];
    public $semIndex;
    public $subjectId;
    public $title='';
    public array $selectedSubjects = [];
    public $isOpen = false;

    public function render()
    {
        return view('livewire.create-structure', [ 
            'subjects' => Subject::all(),
            ])->layout('layouts.app'); 
    }


        public function openModal($index) {
    $this->isOpen = true;
    $this->semIndex = $index;
  
    }


    public function addSemester() {
        $this-> structure[] = ['subs' => []];
    }


    public function addSelectedSubjects(){
        foreach ($this->selectedSubjects as $id) {

        if (!in_array($id, $this->structure[$this->semIndex]['subs'])){
            $this-> structure[$this->semIndex]['subs'][] = Subject::find($id);
        }
        }
        $this->selectedSubjects = [];
        $this->isOpen = false;
        
    }

    public function closeModal(){
        $this->isOpen = false;
    }
    
    public function removeFromTable($semIndex, $id) {
        $key = $this-> structure[$this->semIndex]['subs'];

        foreach($key as $i => $sub){
            if ($sub->id == $id){
                unset($key[$i]);
            }
        }     

            
            $this-> structure[$this->semIndex]['subs'] = array_values($key);
    }

    public function store() {

    $this->validate([
        'title' => ['required','string','max:255'],
       'structure' => ['required', 'array'],
         ]);

        $struct = ProgramStructure::create([
        'program_structure_name' => $this->title,
        'program_id' => 1,
        'created_by' => 1,
        ]);

        foreach($this->structure as $index => $semester) {
        $semesterNum = $index + 1;

        foreach ($semester['subs'] as $subject){
        ProgramSubject::create([
        'program_structure_id'=> $struct->id,
        'semester_number' => $semesterNum,
        'subject_id' => $subject->id,
        ]);
        }
        }

        session()->flash('message','Structure successfully saved and submitted for review.');

        $this->title='';
    }

}
