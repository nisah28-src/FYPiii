<?php

use Livewire\Component;
use App\Models\Subject;

new class extends Component
{
    public $subjects, $subject_id, $subject_name, $subject_code, $credit_hours, $prereq;
    public $isOpen = 0;


    public function render(){
        $this->subjects = Subject::all();
        return view('post.struct');
    }

    public function create(){
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal(){
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->subject_name = '';
        $this->subject_code = '';
        $this->credit_hours = '';
        $this->subject_id = null;
    }

    public function store()
    {
        $this->validate ([
            'subject_name' => 'required',
            'subject_code' => 'required',
            'credit_hours' => 'required',
        ]);

        Subject::updateOrCreate(['id' => $this->subject_id], [
           'subject_name' => $this->subject_name,
            'subject_code' => $this->subject_code,
            'credit_hours' => $this->credit_hours, 
        ]);

        session()->flash('message', 

            $this->subject_id ? 'Post Updated Successfully.' : 'Post Created Successfully.');

  

        $this->closeModal();

        $this->resetInputFields();
    }

    
};
?>

<div>
   <h1> Test Table</h1>

   <div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

            @if (session()->has('message'))

                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">

                  <div class="flex">

                    <div>

                      <p class="text-sm">{{ session('message') }}</p>

                    </div>

                  </div>

                </div>

            @endif

          <button wire:click="create()" class="bg-blue-500">Add Subject</button>
          @if ($isOpen)
                @include('livewire.create')
        @endif 
        <table class="table-fixed w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Credit Hour</th>
                </tr> 
</thead>
<tbody>
    @foreach($subjects as $subject)
    <tr>
        <td> {{ $subject->subject_name}} </td>
        <td> {{ $subject->subject_code}}</td>
        <td> {{$subject->credit_hours }}</td>
</tr>
        @endforeach
</tbody>
</table>

</div>