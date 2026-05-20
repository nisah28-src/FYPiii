<x-app-layout>
    <div class="p-6 space-y-6">
<div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">CCI Subjects</h1>
            @if ($role === 'HOP')
            <a class="btn btn-outline  bg-black text-white p-2"  href="{{ route('subject.create') }}" >Add Subject</a>
            @endif
        </div>
        <p class="p-4"> Status of Subject maybe edited by HOD and HOP, changes will align with the program structures</p>

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
            <div class="overflow-x-auto w-full rounded-box">
             <table class=" table table-zebra w-full text-sm">
                <thead class="bg-slate-900/50 border-b border-slate-700">
                <tr> 
                    <th>Subject Name</th>
                    <th> Subject Code</th>
                    <th> Credit Hours</th>
                    <th>Category</th>
                    <th>Pre-Requisite</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                 @foreach($group as $sub)
                <tr class="hover:bg-slate-300/50 transition-colors">
                   <td> {{ $sub-> subject_name}} </td>
                   <td> {{ $sub-> subject_code}}</td>
                    <td> {{ $sub-> credit_hours}}</td> 
                     <td> {{ $sub-> category_type}}</td>
                     @forelse ($sub->prerequisites as $pre)
                     <td> {{ $pre -> subject_name }}</td>
                     @empty
                     <td> None</td>
                     @endforelse
                     <td>

                     @if($role === 'HOD' || $role === 'HOP')
                        <form action="{{ route('subjects.toggle-status', $sub->id) }}" method="POST">
                            @csrf
                            <!-- Resource update wajib guna PUT atau PATCH -->
                            
                            @if($sub->is_active) 
                                <button type="submit" class="btn btn-sm btn-success">
                                    Active
                                </button>
                            @else
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    Inactive
                                </button>
                            @endif
                        </form>
                        @else
                            @if($sub->is_active) 
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                        @endif
                     </td>
                     <td> 
                     <label for="show-subject-modal-{{ $sub->id }}" class="btn btn-primary btn-sm">View</label>
                     <input type="checkbox" id="show-subject-modal-{{ $sub->id }}" class="modal-toggle" /> 
                        <div class="modal">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg">Subject Details</h3>
                                <p class="py-4"> Subject Name: {{ $sub -> subject_name }} </p>
                                <p class="py-4"> Subject Code: {{ $sub -> subject_code }} </p>
                                <p class="py-4"> Credit Hours: {{ $sub -> credit_hours }} </p>
                                <p class="py-4"> Category: {{ $sub -> category_type }} </p>
                                <p class="py-4"> Pre-Requisite: 
                                    @forelse ($sub->prerequisites as $pre)  
                                        {{ $pre -> subject_name }}  
                                    @empty
                                        None
                                    @endforelse
                                </p>
                                <div class="modal-action">
                                    <label for="show-subject-modal-{{ $sub->id }}" class="btn">Close</label>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('subject.edit', $sub->id) }}" class="btn btn-accent btn-sm p-2 mt-2">Edit</a>

                     <form action="{{ route('subject.destroy', $sub) }}" method="POST">
                     @csrf 
                     @method('DELETE')
                      <button onclick="return confirm('Delete this subject?')" class="btn btn-warning" > Remove</button> </form> </td>
                </tr>
                @endforeach
                </tbody>
            </table>  
            </div>      
                
        @endforeach
        @else 
            <p>No subject inserted yet</p>
        </div>
    </div>
        @endif





</x-app-layout>