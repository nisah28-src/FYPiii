<x-app-layout>
    <h1 class="text-3xl font-bold p-4"> CCI Subjects </h1>
<p class="p-4"> Status of Subject maybe edited by HOD and HOP, changes will align with the program structures</p>

<a class="btn btn-outline  bg-black text-white p-2"  href="{{ route('subject.create') }}" >Add Subject</a>

 {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif



        @if($subjects->count())

        <div class="card bg-slate-200  border border-base-300 m-4">
            <div class="card-body m-2 shadow-md">
        @foreach($subjects as $prefix => $group)

        <h3 class="font-bold p-6">{{ $prefix }}</h3>
        <table class=" table table-zebra w-full text-sm">
            <thead class="bg-slate-900/50 border-b border-slate-700">
                <tr> 
                    <th>Subject Name</th>
                    <th> Subject Code</th>
                    <th> Credit Hours</th>
                    <th>Category</th>
                    <th>Pre-Requisite</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                 @foreach($group as $sub)
                <tr onclick="window.location='{{ route('subject.show', $sub->id) }}'"
                class="cursor-pointer hover:bg-slate-800 transition">
                   <td> {{ $sub-> subject_name}} </td>
                   <td> {{ $sub-> subject_code}}</td>
                    <td> {{ $sub-> credit_hours}}</td> 
                     <td> {{ $sub-> category_type}}</td>
                     @forelse ($sub->prerequisites as $pre)
                     <td> {{ $pre -> subject_name }}</td>
                     @empty
                     <td> None</td>
                     @endforelse
                     <td> <button class="btn btn-warning"> Remove</button>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                    
                
                    @endforeach
                    @else 
                <p>No subject inserted yet</p>
                </div>
                </div>
                    

        @endif


</div>

</x-app-layout>