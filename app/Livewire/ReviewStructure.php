<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProgramStructure;
use App\Models\ApprovalRequest;
use App\Models\ApprovalHistory;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class ReviewStructure extends Component
{
   public $structureId;
   public $remarks = '';

    public function render()
    {
        // Kita load data di sini supaya sentiasa fresh
        $structure = ProgramStructure::with('programSubjects.subject')
                ->find($this->structureId);

        return view('livewire.review-structure', [
        'structure' => $structure,
        'subjects' => Subject::all(),
        ]);
    }

    public function mount($id) {
        $this->structureId = $id;
    }

    public function approve(){
        
        DB::transaction(function() {

        $approvalRequest = ApprovalRequest::where('program_structure_id', $this->structureId)->first();

        if ($approvalRequest) {
            $approvalRequest->update([
                'status' => 'approved',
                'review_by' => auth()->id(),
            ]);

            $structure = ProgramStructure::find($this->structureId);
            $structure->update(['status' => 'approved',]);

            ApprovalHistory::create([
                'approval_request_id' => $approvalRequest->id,   
                'action' => 'approved',
                'remarks' => $this->remarks,
                'action_by' => auth()->id(),
            ]);
        }
        });
    
        session()->flash('message', 'Program structure approved successfully!');
            return redirect()->route('hop.dashboard');
    }

    public function reject(){
        DB::transaction(function() {

         $approvalRequest = ApprovalRequest::where('program_structure_id', $this->structureId)->first();

            if ($approvalRequest) {
                $approvalRequest->update([
                    'status' => 'rejected',
                    'review_by' => auth()->id(),
                ]);
            }
                $structure = ProgramStructure::find($this->structureId);
                $structure->update(['status' => 'rejected',]);
        

            ApprovalHistory::create([
                'approval_request_id' => $approvalRequest->id,
                'action' => 'rejected',
                'remarks' => $this->remarks,
                'action_by' => auth()->id(),
            ]);
        });

        session()->flash('message', 'Program structure rejected.');
        return redirect()->route('hop.dashboard');
    }
}