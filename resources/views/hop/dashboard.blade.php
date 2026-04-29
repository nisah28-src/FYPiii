<x-app-layout>

<h2 class="text-3xl p-4 font-bold"> Welcome, Head Of Program</h2>

<h2 class="text-xl p-2 font-bold"> Your Program:  </h2>

<div class="max-w-5xl mx-auto"> <div class="p-6">
    <div class="grid grid-cols-2 gap-2">
    <div class="flex items-center justify-between">
        <x-card title="Draft Submitted" count="{{ $totalPending }}" class=" text-base-content"/>
    </div>   
    <div class="flex items-center justify-between">        
        <x-card title="Approved Structure" count="{{ $totalApproved }}" class=" text-base-content"/>
    </div>
</div>
</div>
</div>
    
<div class="p-4 border-b border-slate-700">
    
    <div class="mb-6">
                <h2 class="text-lg font-bold text-white ">List of Drafts</h2>
                <p class="text-sm text-slate-400">You can view approved structure in the Structures Section</p>
</div>
</div>

 <div class="overflow-x-auto rounded-box border border-slate-700 bg-slate-800/40">
        <table class="table text-center w-full">
            <thead class="bg-slate-900/50 border-b border-slate-700">
                <tr> 
                    <th>Name</th>
                    <th class="text-center">Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
</thead>
<tbody> @foreach ($drafts as $structure)
                <tr>
                    <td>{{ $structure->program_structure_name }}</td>
                    <td>{{ $structure->created_at }}</td>
                    <td>{{ $structure->status }}</td>
                    <td> <a href="{{ route('program.view',$structure->id) }}"><button class="btn btn-primary"> Update </button></a>
                    <button> <a href ="{{ route('structure.duplicate',$structure->id)}}"> Duplicate</a>
</button></td>
                   
</tr>
</tbody> @endforeach
</table>
</div>

@if($drafts->count())
    @else
    <p class="text-center mt-6 mb-6">No structure submitted yet</p>
    @endif


</x-app-layout>

