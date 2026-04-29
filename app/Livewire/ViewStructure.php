<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subject;
use App\Models\ProgramSubject;
use App\Models\ProgramStructure;



class ViewStructure extends Component
{

    
    public $structureId;
    public $isOpen = false;
    public $semIndex;
    public array $selectedSubjects=[];
    public $extraSemesters=[];

    public function mount($id)
{
    
      $this->structureId = $id;
        
}


    public function addSem() {
        $lastSem = ProgramSubject::where('program_structure_id', $this->structureId)->max('semester_number') ?? 0;

        $maxSem = count($this->extraSemesters) > 0 ? max($this->extraSemesters) : 0;

        $nextSem = max($lastSem, $maxSem) + 1;

        $this->extraSemesters[] = $nextSem;
    }

    public function OpenModal($semester) {
        $this->isOpen = true; 
        $this->semIndex = $semester;
    }

    public function addSelectedSubjects() {

    foreach($this->selectedSubjects as $id) {
        $exists = ProgramSubject::where('program_structure_id', $this->structureId)
                    ->where('subject_id', $id)
                    ->where('semester_number', $this->semIndex) // Check sem spesifik tu
                    ->exists();
       if(!$exists) {
         ProgramSubject::create([
            'program_structure_id' => $this->structureId,
            'semester_number' => $this->semIndex,
            'subject_id' => $id,
        ]);}
    }
    $this->extraSemesters = array_diff($this->extraSemesters, [$this->semIndex]);

    $this->closeModal();
    }

    public function closeModal(){
        $this->isOpen = false;
    }



    public function finalize()
{
    // Contoh: Kemaskini status kalau ada column status
    $struct = ProgramStructure::find($this->structureId);
    $struct->update(['status' => 'draft']);

    session()->flash('message', 'Structure finalized successfully!');
    return redirect()->route('hop.dashboard');
}

    public function removeFromTable($id, $sem) 
{
    // Terus delete dari DB
    ProgramSubject::where('program_structure_id', $this->structureId)
        ->where('subject_id', $id)
        ->where('semester_number', $sem)
        ->delete();

    // Opsional: Kalau sis nak pastikan "Empty Semester" tak hilang dari view,
    // sis boleh masukkan balik sem tu dalam extraSemesters kalau dia dah kosong.
    // Tapi buat masa ni, biarkan Livewire handle render pun dah cukup.
    
    session()->flash('message', 'Subjek berjaya dikeluarkan.');
}


public function duplicate()
{
    // 1. Cari structure asal
    $original = ProgramStructure::with('programSubjects')->findOrFail($this->structureId);

    // 2. Replicate structure tu (copy properties dia)
    $newStructure = $original->replicate();
    
    // 3. Ubah nama sikit supaya user tak pening
    $newStructure->program_structure_name = $original->program_structure_name . ' (V2)';
    $newStructure->status = 'draft'; // Reset status jadi draft
    $newStructure->save();

    // 4. Copy semua subjek-subjek dia
    foreach ($original->programSubjects as $subject) {
        $newSubject = $subject->replicate();
        $newSubject->program_structure_id = $newStructure->id; // Link kan ke structure baru
        $newSubject->save();
    }

    session()->flash('message', 'Structure successfully duplicated as V2!');

    // Redirect ke page edit structure yang baru tu
    return redirect()->route('structure.duplicate', $newStructure->id);
}

    public function render()
    {

    $structure = ProgramStructure::with('programSubjects.subject')->findOrFail($this->structureId);

    $grouped = [];
    foreach ($structure->programSubjects as $p) {
        if ($p->subject) {
            $sem = $p->semester_number;            
            $grouped[$sem][] = $p->subject;
        }
    }

    foreach ($this->extraSemesters as $emptySem) {
        if (!isset($grouped[$emptySem])){
            $grouped[$emptySem] = [];
        }
    }

        ksort($grouped);

        return view('livewire.view-structure', ['structure' => $structure,
        'group' => $grouped,
        'subjects' => Subject::all(),
        ]);
    }
}
