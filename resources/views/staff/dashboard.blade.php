<x-app-layout>

<h2 class="text-3xl p-4 font-bold"> Welcome, Staff</h2>

    <div class="max-w-5xl mx-auto"> <div class="p-6">
    <div class="grid grid-cols-2 gap-2">
    <div class="flex items-center justify-between">
        <x-card title="Approved Structure" count="{{ $totalApproved }}" class=" text-base-content"/>
    </div>   
    <div class="flex items-center justify-between">        
        <x-card title="CCI Program" count="{{ $totalProgram }}" class="text-base-content"/>
    </div>
</div>
</div>
</div>
    
<div class="p-4 border-b border-slate-700">
    
    <div class="mb-6">
                <h2 class="text-lg font-bold text-white ">List of Approved Structures</h2>
                <p class="text-sm text-slate-400"></p>
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
</div>
</x-app-layout>
