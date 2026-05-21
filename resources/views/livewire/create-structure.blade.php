
<div>
    {{-- Nothing worth having comes easy. - Theodore Roosevelt --}}



    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

     <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-start gap-6">
        <div class="space-y-4 w-full">
            <h1 class="text-2xl font-bold text-slate-800">Create Structure</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600">Structure Name</label>
                    <input type="text" class="input input-bordered w-full mt-1" placeholder="e.g., Semester Plan 2026" wire:model="title">
                </div>
                <div class="flex items-end">
                    <label class="flex items-center gap-2 cursor-pointer p-3 border rounded-lg hover:bg-slate-50">
                        <input type="checkbox" class="checkbox checkbox-primary" wire:model="studenttype">
                        <span class="text-sm font-medium">Made for International</span>
                    </label>
                </div>
            </div>
            <div class="text-sm text-slate-500">

                <span class="font-bold text-amber-600">Status:</span> Draft
            </div>
        </div>


        <div class="flex gap-2 shrink-0">
            <button class="btn btn-outline" wire:click="store">Save Draft</button> 
            <button class="btn btn-accent" wire:click="back">Back to Dashboard</button>
            @if ($structureId)
                <button class="btn btn-primary" wire:click="submit">Submit for Approval</button>
            @endif
        </div>
    </div>

    <div class="m-4">
    <button class="btn btn-sm btn-primary" wire:click="addSemester()">+ Add Semester</button>
    </div>

    <div class="max-h-[600px] overflow-y-auto">
        @foreach($structure as $index => $semester)
        <div class="card bg-slate-200  border border-base-300 m-4">
            <div class="card-body m-2 shadow-md">
            <h2>Semester {{ $loop->iteration }}</h2>

            <button class="btn btn-primary" wire:click="openModal({{ $index }})"> Add Subjects</button>
            <div class="inline-flex gap-2 justify-center">
                <button wire:click="moveUp({{ $index }})" class="btn btn-sm btn-secondary mb-2">Move Up</button>
                <button wire:click="moveDown({{ $index }})" class="btn btn-sm btn-secondary mb-2">Move Down</button>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full text-sm">
                    <thead><tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Credit</th>
                    <th> Action</th>
                    </tr></thead>
                    <tbody>
                    @forelse($semester['subs'] as $sub)
                    <tr>
                    <td> {{ $sub['subject_name'] }} </td>
                    <td> {{ $sub['subject_code'] }} </td>
                    <td> {{ $sub['credit_hours'] ?? 0 }} </td>
                    <td> 
                        <button class="btn btn-error btn-sm" wire:click="removeFromTable({{ $index }},{{ $sub['id'] }})">Remove</button></td></tr>
                    @empty
                    <tr>
                        <td>No subject Added yet</td>
                    </tr>
                    @endforelse
                    </tbody>
                    </table>
                </div>

                <div class="text-right text-primary font-semibold">
                    Total Credit:
                    {{ collect($semester['subs'])->sum(function($sub) {
                    return $sub['credit_hours'] ?? 0;})
                    }}
                    </div>
            </div>
        </div>  
        @endforeach
</div>



@if ($isOpen)
<dialog open class="modal">
  <div class="modal-box">
    <h3 class="text-lg font-bold">Choose Subjects</h3>
    <p class="py-4">Subject selected will be listed in the table on the page</p>
        <!-- if there is a button in form, it will close the modal -->
    <input type="text" 
       wire:model.live.debounce.300ms="searchSubject" 
       placeholder="Search subject..." 
       class="input input-bordered w-full mb-2">

<ul class="max-h-[300px] overflow-y-auto border p-2">
    @foreach($subjects as $subject)
        <li class="flex items-center gap-2 p-1 hover:bg-gray-100">
            <input type="checkbox" 
                   value="{{ $subject->id }}" 
                   wire:model="selectedSubjects" 
                   class="checkbox checkbox-sm"> 
            
            <span> {{ $subject->subject_name }}</span>
        </li>
    @endforeach
    
    @if($subjects->isEmpty())
        <li class="p-2 text-gray-500">No Subject Found</li>
    @endif
</ul>
        <button class="btn" wire:click="addSelectedSubjects">Add</button>
        <button class="btn" wire:click="closeModal">Close</button>
  </div>
</dialog>
@endif


</div>