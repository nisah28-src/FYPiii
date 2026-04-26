<x-app-layout>
    <h1 class="text-3xl font-bold p-4"> Structures</h1>
<p class="p-4"> List of Approved drafts of structures maybe viewed here</p>


 {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


        <table class=" table text-center w-full">
            <thead class="bg-slate-900/50 border-b border-slate-700">
                <tr> 
                    <th></th>
                    <th>Version</th>
                    <th> Status</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Date Approved</th>
                </tr>
                </thead>

                <tbody>
                   

</tbody>
</table>
<p class="text-center">No structure approved yet</p>



</div>

</x-app-layout>