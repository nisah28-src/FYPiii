<x-app-layout>
    <div class="w-full px-4 py-6 space-y-6">
        <h2 class="text-3xl font-bold">Welcome, Head Of Program</h2>
        <h2 class="text-lg text-slate-500 font-semibold">Your Program: {{ auth()->user()->program_name }}</h2>

        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat bg-blue-50 border border-blue-200 rounded-lg shadow-sm p-4">
                <div class="stat-title text-blue-600 font-medium">Draft Created</div>
                <div class="stat-value text-slate-800">{{ $totalDraft }}</div>
            </div>
            <div class="stat bg-amber-50 border border-amber-200 rounded-lg shadow-sm p-4">
                <div class="stat-title text-amber-600 font-medium">Pending Approval</div>
                <div class="stat-value text-slate-800">{{ $totalPending }}</div>
            </div>
            <div class="stat bg-emerald-50 border border-emerald-200 rounded-lg shadow-sm p-4">
                <div class="stat-title text-emerald-600 font-medium">Approved</div>
                <div class="stat-value text-slate-800">{{ $totalApproved }}</div>
            </div>
        </div>

        <div class="pt-6">
            <h2 class="text-xl font-bold text-slate-700">List of Documents</h2>
            <p class="text-sm text-slate-500">Manage your program structure status below</p>
        </div>

        @forelse ($drafts as $status => $structure)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
                <div class="p-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="font-bold text-slate-700 uppercase tracking-wider">{{ $status }} Structures</h3>
                    <span class="badge badge-lg badge-ghost">
                        {{ count($structure) }} items
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="table w-full text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr> 
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach ($structure as $sub)
                                <tr class="hover">
                                    <td class="font-medium text-slate-800">{{ $sub->program_structure_name }}</td>
                                    <td class="text-slate-500">{{ $sub->created_at->format('d/m/Y h:i A') }}</td>
                                    <td>
                                        <span class="badge badge-outline {{ $sub->status === 'approved' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($sub->status) }}
                                        </span>
                                    </td>
                                    <td class="flex justify-center gap-2"> 
                                        @if ($sub->status === 'draft')
                                            <a href="{{ route('program.view',$sub->id) }}" class="btn btn-sm btn-primary">Update</a>
                                            <a href="{{ route('structure.duplicate',$sub->id) }}" class="btn btn-sm btn-ghost">Duplicate</a>
                                        @elseif ($sub->status === 'pending')
                                            <a href="{{ route('program.view', $sub->id) }}" class="btn btn-sm btn-primary">View</a>
                                        @elseif ($sub->status === 'approved')
                                            <a href="{{ route('program.view', $sub->id) }}" class="btn btn-sm btn-outline btn-success">View</a>
                                        @elseif ($sub->status === 'rejected')
                                            <a href="{{ route('program.view', $sub->id) }}" class="btn btn-sm btn-error">Update</a>
                                        @endif
                                        <form action="{{ route('hop.destroy', $sub->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error btn-outline">Delete</button>
                                        </form>
                                    </td>  
                                </tr>
                            @endforeach
                        </tbody> 
                    </table>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-slate-400 bg-white rounded-xl border border-dashed">
                No structures found.
            </div>
        @endforelse
    </div>
</x-app-layout>