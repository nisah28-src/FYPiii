<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subject;
use App\Models\ProgramSubject;
use App\Models\ProgramStructure;
use Illuminate\Support\Facades\DB;
use App\Models\ApprovalRequest;
use App\Models\ApprovalHistory;



class ViewStructure extends Component
{

    
    public $structureId;
    public $title;
    public $isOpen = false;
    public $semIndex;
    public array $selectedSubjects=[];
    public $extraSemesters=[];

    public function mount($id)
{
    
      $this->structureId = $id;
        $structure = ProgramStructure::findOrFail($id);
        $this->title = $structure->program_structure_name;
        
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
    
    $struct->update(['program_structure_name' => $this->title,
    'status' => 'draft']);

     $programSubjects = ProgramSubject::where('program_structure_id', $this->structureId)->get();

            foreach ($programSubjects as $ps) {

            $masterSubject = Subject::find($ps->subject_id);

            if ($masterSubject) {
                $ps->update([
                    'subject_name_snapshot' => $masterSubject->subject_name,
                    'credit_hours_snapshot' => $masterSubject->credit_hours,
                ]);
            } else {
                $ps->update([
                    'subject_code' => 'Subjek Tiada (Data Master Padam)',
                    'subject_name' => 'Subjek Tiada (Data Master Padam)',
                    'credit_hours' => 0,
                ]);
            }
            }

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

   public function submit() {

    if (!$this->structureId) {
        session()->flash('error', 'Sila tekan "Save" dahulu sebelum Submit.');
        return;
    }
        DB::transaction(function() {
        $programStructure = ProgramStructure::findOrFail($this->structureId);
        $programStructure->update([ 
        'program_structure_name' => $this->title,
        'status' => 'Pending' ]);

        ApprovalRequest::updateOrCreate([
            'program_structure_id' => $this->structureId,
            'status' => 'Pending',
            'requested_by' => auth()->id(),
        ]);

         $programSubjects = ProgramSubject::where('program_structure_id', $this->structureId)->get();
        
            foreach ($programSubjects as $ps) {
                
            $masterSubject = Subject::find($ps->subject_id);


            if ($masterSubject) {
              $prereqCodes = $masterSubject->prerequisites()->pluck('subject_code')->unique()->values()->toArray(); 
              
             

            \DB::table('program_subjects')->where('id', $ps->id)
            ->update([
                'subject_name_snapshot' => $masterSubject->subject_name,
                'subject_code_snapshot' => $masterSubject->subject_code,
                'credit_hours_snapshot' => $masterSubject->credit_hours,
                'prerequisites' => json_encode($prereqCodes),
            ]); }
                    
            } });
        
        session()->forget(['draft_structure', 'draft_title']);
        session()->flash('message', "Successfully submitted for review");
    }

    public function moveUp($currentSem) {
        if ($currentSem <= 1) return; // Tak boleh move up kalau dah kat atas (sem 1)

        $targetSem = $currentSem - 1;

    $this->swapSemesters($currentSem, $targetSem);
    }


    public function moveDown($currentSem) {
        $maxSem = ProgramSubject::where('program_structure_id', $this->structureId)->max('semester_number');
    
    if ($currentSem >= $maxSem) return; // Dah paling bawah

    $targetSem = $currentSem + 1;

    $this->swapSemesters($currentSem, $targetSem);
    }

    private function swapSemesters($currentSem, $targetSem)
{
    DB::transaction(function () use ($currentSem, $targetSem) {
        // 1. Tukar currentSem jadi temporary (contoh: 99) supaya tak bertembung (constraint)
        ProgramSubject::where('program_structure_id', $this->structureId)
            ->where('semester_number', $currentSem)
            ->update(['semester_number' => 99]);

        // 2. Tukar targetSem jadi currentSem
        ProgramSubject::where('program_structure_id', $this->structureId)
            ->where('semester_number', $targetSem)
            ->update(['semester_number' => $currentSem]);

        // 3. Tukar temporary (99) tadi jadi targetSem
        ProgramSubject::where('program_structure_id', $this->structureId)
            ->where('semester_number', 99)
            ->update(['semester_number' => $targetSem]);

            
        // 4. Update juga dalam extraSemesters kalau ada (supaya UI konsisten)
        // Kita cuma swap value dalam array kalau wujud
        if (in_array($currentSem, $this->extraSemesters) || in_array($targetSem, $this->extraSemesters)) {
            // Logic ni optional kalau kau guna database-driven view sepenuhnya
            $this->extraSemesters = []; 
        }
    });
    session()->flash('message', "Semester $currentSem dan $targetSem telah ditukar kedudukan.");
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
