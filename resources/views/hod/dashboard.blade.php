<x-app-layout>
    <div class="w-full px-6 py-6 space-y-8">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-slate-800">Welcome, Head Of Department</h2>
            <p class="text-slate-500">Manage and review incoming program structure requests.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="stat bg-amber-50 border border-amber-200 rounded-lg shadow-sm p-4">
                <div class="stat-title text-amber-600 font-medium">To Be Reviewed</div>
                <div class="stat-value text-amber-800">{{ $toReview->count() }}</div>
            </div>
            <div class="stat bg-emerald-50 border border-emerald-200 rounded-lg shadow-sm p-4">
                <div class="stat-title text-emerald-600 font-medium">Approved Structures</div>
                <div class="stat-value text-emerald-800">{{ $totalApproved }}</div>
            </div>
        </div>

        @foreach (['pending' => $toReview, 'approved' => $approved] as $status => $structures)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 {{ $status == 'approved' ? 'bg-emerald-50' : 'bg-amber-50' }} border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold {{ $status == 'approved' ? 'text-emerald-900' : 'text-amber-900' }} uppercase tracking-wider">
                        {{ ucfirst($status) }} Structures
                    </h3>
                    <span class="badge {{ $status == 'approved' ? 'badge-success' : 'badge-warning' }} text-white">
                        {{ $structures->count() }} items
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($structures as $s)
                                <tr class="hover:bg-slate-50">
                                    <td class="font-medium text-slate-800">{{ $s->program_structure_name }}</td>
                                    <td class="text-slate-500">{{ $s->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge {{ $status == 'approved' ? 'badge-success' : 'badge-warning' }} badge-outline">
                                            {{ ucfirst($s->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($status == 'pending')
                                            <a href="{{ route('review.structure', $s->id) }}" class="btn btn-sm btn-primary">Review</a>
                                        @else
                                            <span class="text-slate-400 text-xs italic">View Only</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-slate-400 italic">No {{ $status }} structures found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>