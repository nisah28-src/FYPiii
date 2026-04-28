<div>
    {{-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca --}}

    <h1>Update Structure</h1>
    <h2>Name: {{$structure->program_structure_name }}</h2>
<div>
    <button class="btn btn-success btn-lg m-6" wire:click="finalize"> Finalize & Back to Dashboard</button>
</div>
    <button wire:click="addSem" class="btn btn-outline-success w-100">
    + Add New Semester
</button>

    @foreach ($group as $sem => $subs)

    <div class="card bg-slate-200  border border-base-300 m-4">
        <div class="card-body m-2 shadow-md">
        <h4> Semester {{ $sem }}</h4>
        <button class="btn btn-primary" wire:click="OpenModal({{ $sem }})"> Add Subjects</button>
     <div class="overflow-x-auto">
                <table class="table table-zebra w-full text-sm">
                    <thead class="bg-slate-900/50 border-b border-slate-700"><tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Credit</th>
                    <th> Action</th>
                    </tr></thead>
                    <tbody>
                    @forelse($subs as $sub)
                    <tr>
                    <td> {{ $sub->subject_name }} </td>
                    <td> {{ $sub->subject_code }} </td>
                    <td> {{ $sub->credit_hours }} </td>
                    <td> 
                        <button class="btn btn-error btn-sm" wire:click="removeFromTable({{ $sub->id }}, {{ $sem }})">Remove</button></td></tr>
                    @empty
                    <tr>
                        <td>No subject Added yet</td>
                    </tr>
                    @endforelse
                    </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        @endforeach


@if ($isOpen)
<dialog open class="modal">
  <div class="modal-box">
    <h3 class="text-lg font-bold">Choose Subjects</h3>
    <p class="py-4">Subject selected will be listed in the table on the page</p>
        <!-- if there is a button in form, it will close the modal -->
        <input type="text" wire:model.live="searchSubject" placeholder="Search subject..." class="input input-bordered w-full mb-2">
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
