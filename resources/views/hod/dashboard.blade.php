<x-app-layout>

<h2 class="text-3xl p-4 font-bold"> Welcome, {{ $role }}</h2>

    <div class="max-w-5xl mx-auto"> <div class="p-6">
    <div class="grid grid-cols-2 gap-2">
    <div class="flex items-center justify-between">
        <x-card title="To be Reviewed" count="{{ $toReview->count() }}" class=" text-base-content"/>
    </div>   
    <div class="flex items-center justify-between">        
        <x-card title="Aprroved Structure"/>
    </div>
</div>
</div>
</div>
    
    <div class="p-4 border-b border-slate-700">
    
    <div class="mb-6">
                <h2 class="text-lg font-bold text-white ">List of Drafts</h2>
                <p class="text-sm text-slate-400">You can view approved drafts in the Structures Section</p>
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
<tbody> @foreach ($toReview as $structure)
                <tr>
                    <td>{{ $structure->program_structure_name }}</td>
                    <td>{{ $structure->created_at }}</td>
                    <td>{{ $structure->status }}</td>
                   
</tr>
</tbody> @endforeach
</table>
</div>
</x-app-layout>

