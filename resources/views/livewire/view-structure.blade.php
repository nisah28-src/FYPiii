<div>
    {{-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca --}}


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

    
    <div class="p-6 max-w-5xl mx-auto space-y-6">
    {{-- Header Sticky - Melekat kat atas --}}
    <div class="sticky top-0 z-20 bg-slate-50/95 backdrop-blur-sm p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Update Structure</h1>
            <p class="text-lg text-slate-500 font-medium">Name: <span class="text-blue-600">{{ $structure->program_structure_name }}</span></p>
            <p class="text-sm text-slate-500">Created At: {{ $structure->created_at->format('d M Y, H:i') }}</p>
            <p class="text-sm text-slate-500">Status: {{ $structure->status}} </p>
        </div>

        <div class="flex gap-2">
            @if ($structure->status == 'draft')
            <button class="btn btn-outline btn-sm" wire:click="finalize">Finalize & Back</button>
            <button class="btn btn-primary btn-sm" wire:click="submit">Submit</button>
            @endif

        </div>
    </div>
    @if ($structure->status == 'draft' || $structure->status == 'rejected')
    <button wire:click="addSem" class="btn btn-outline-success w-100">
    + Add New Semester
</button>
@endif

    @foreach ($group as $sem => $subs)

    <div class="card bg-slate-200  border border-base-300 m-4">
        <div class="card-body m-2 shadow-md">
        <h4> Semester {{ $sem }}</h4>
        <div class="inline-flex gap-2 justify-center">
</div>

        @if ($structure->status == 'draft' || $structure->status == 'rejected')
        <button class="btn btn-primary" wire:click="OpenModal({{ $sem }})"> Add Subjects</button>
        @endif
     <div class="overflow-x-auto">
                <table class="table table-zebra w-full text-sm">
                    <thead class="bg-slate-900/50 border-b border-slate-700"><tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Credit</th>
                    <th>Prerequisites</th>
                    @if ($structure->status == 'draft' || $structure->status == 'rejected')
                    <th> Action</th>
                    @endif

                    </tr></thead>
                    <tbody>
                    @forelse($subs as $sub)
                    <tr>
                    <td> {{ $sub->subject_name }} </td>
                    <td> {{ $sub->subject_code }} </td>
                    <td> {{ $sub->credit_hours }} </td>
                    <td>
                    @if (!empty($sub->prerequisites))
                    <ul>
                    @foreach ($sub->prerequisites as $prereq)
                    <li>{{ $prereq->subject_code }}</li>
                    @endforeach
                    </ul>
                    @else
                    None
                    @endif
                    </td>
                    @if ($structure->status == 'draft' || $structure->status == 'rejected')
                    <td> 
                        <button class="btn btn-error btn-sm" wire:click="removeFromTable({{ $sub->id }}, {{ $sem }})">Remove</button></td></tr>
                        @endif
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
