<x-app-layout>

<h2 class="text-3xl p-4 font-bold"> Welcome, {{ $role }}</h2>

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

        <table class="table text-center w-full">
            <thead class="bg-slate-900/50 border-b border-slate-700">
                <tr> 
                    <th class="py-4"> Name</th>
                    <th class="text-center"> Created At</th>
                    <th class="text-right"> Status</th>
                </tr>
    </thead>
</table>

@if($drafts->count())
    @else
    <p class="text-center mt-6 mb-6">No structure submitted yet</p>
    @endif


</x-app-layout>

