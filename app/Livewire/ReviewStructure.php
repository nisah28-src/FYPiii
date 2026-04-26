<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProgramSubject;
use App\Models\ProgramStructure;

class ReviewStructure extends Component
{
    public array $structure = [];

public function mount($id)
{
    $this->subjects = DB::table('structure_pivot_table')
    ->join('subjects', 'subjects.Subject_ID', '=', 'structure_pivot_table.Subject_ID')
    ->where('Program_ID', $this->structure->Program_ID)
    ->get();
      $this->structure = ProgramStructure::with('subjects')->findOrFail($id);
       
}

    public function render()
    {
        return view('livewire.review-structure');
        
    }
}
