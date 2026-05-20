<x-app-layout>
 <div class="p-4 space-y-4">
<h2 class="text-3xl p-4 font-bold"> Welcome, {{ $role }}</h2>

<h2 class="text-xl p-2 font-bold"> Your Program:  </h2>

 @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

<div class="max-w-5xl mx-auto"> <div class="p-6">
    <div class="grid grid-cols-3 gap-2">
    <div class="flex items-center justify-between">
        <x-card title="Draft Created" count="{{ $totalDraft }}" class=" text-base-content"/>
    </div>   
    <div class="flex items-center justify-between">        
        <x-card title="Approved Structure" count="{{ $totalApproved }}" class=" text-base-content"/>
    </div>
    <div class="flex items-center justify-between">        
        <x-card title="Submitted for Approval" count="{{ $totalPending }}" class=" text-base-content"/>
    </div>
</div>
</div>
</div>
    
<div class="p-4 border-b border-slate-700">
    
    <div class="mb-6">
                <h2 class="text-lg font-bold text-white ">List of Documents</h2>
                <p class="text-sm text-slate-400">You can view approved structure in the Structures Section</p>
</div>
</div>

@foreach ($drafts as $group => $structure)
<h2 class="font-bold p-6">{{ $group }}</h2>
     <div class="overflow-x-auto rounded">
        <table class="table table-zebra w-full text-sm">
            <thead class="bg-slate-900/50 border-b border-slate-700">
                <tr> 
                    <th>Name</th>
                    <th class="text-center">Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody> 
    @foreach ($structure as $sub)
                <tr>
                    <td>{{ $sub->program_structure_name }}</td>
                    <td>{{ $sub->created_at->format('d/m/Y h:i A') }}</td>
                    <td>{{ $sub->status }}</td>
                    <td> 
                    @if ($sub->status === 'draft')
                    <a href="{{ route('program.view',$sub->id) }}"><button class="btn btn-primary"> Update </button></a>
                    <button> <a href ="{{ route('structure.duplicate',$sub->id)}}"> Duplicate</a></button>
                    @endif
                  <form action="{{ route('hop.destroy', $sub->id) }}" method="POST">
                     @csrf 
                     @method('DELETE')
                        <button type="submit" class="btn btn-error"> Delete </button>
                    </form>
                    </td>  
                </tr>
                </tbody> 
                @endforeach
        </table>
</div>
@endforeach

@if($drafts->count())
    @else
    <p class="text-center mt-6 mb-6">No structure submitted yet</p>
    @endif


</x-app-layout>

