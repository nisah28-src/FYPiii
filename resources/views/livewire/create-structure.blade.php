
<div>
    {{-- Nothing worth having comes easy. - Theodore Roosevelt --}}



    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl">Create Structure</h1>

            <h3>Program: </h3>
            <h3>Status: Draft </h3>
            <h3>Structure Name:</h3>  <input type="text" class="input input-bordered" placeholder="Enter Structure Name.." wire:model="title">
        </div>

        <button class="btn btn-success btn-lg m-6" wire:click="store"> Submit </button>
    </div>
    <div class="m-4">
    <button class="btn btn-sm btn-primary" wire:click="addSemester()">+ Add Semester</button>
    </div>

    <div class="max-h-[600px] overflow-y-auto">
        @foreach($structure as $index => $semester)
        <div class="card bg-slate-200  border border-base-300 m-4">
            <div class="card-body m-2 shadow-md">
            <h2>Semester {{$index + 1 }}</h2>

            <button class="btn btn-primary" wire:click="openModal({{ $index }})"> Add Subjects</button>
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
                    <td> {{ $sub->subject_name }} </td>
                    <td> {{ $sub->subject_code }} </td>
                    <td> {{ $sub->credit_hours }} </td>
                    <td> 
                        <button class="btn btn-error btn-sm" wire:click="removeFromTable({{ $index }},{{ $sub->id }})">Remove</button></td></tr>
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
                    return $sub->credit_hours?? 0;})
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

        @foreach($subjects as $subject)
        <ul>
            <li>
            <input type="checkbox" value="{{ $subject->id }}" wire:model="selectedSubjects"> {{ $subject -> subject_name }}
            </li>
        </ul>
        @endforeach
        <button class="btn" wire:click="addSelectedSubjects">Add</button>
        <button class="btn" wire:click="closeModal">Close</button>
  </div>
</dialog>
@endif


</div>