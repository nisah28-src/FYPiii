<x-app-layout>
    <div class="w-full px-6 py-6 space-y-8">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-slate-800">Welcome, Staff</h2>
            <p class="text-slate-500">Access and download approved program structures.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="stat bg-emerald-50 border border-emerald-200 rounded-lg shadow-sm p-4">
                <div class="stat-title text-emerald-600 font-medium">Approved Structures</div>
                <div class="stat-value text-emerald-800">{{ $totalApproved }}</div>
            </div>

            
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-700">List of Approved Structures</h2>
                <p class="text-sm text-slate-500">Download available approved documents here.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th>Name</th>
                            <th>Date Approved</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($approved as $structure)
                            <tr class="hover:bg-slate-50">
                                <td class="font-medium text-slate-800">{{ $structure->program_structure_name }}</td>
                                <td class="text-slate-500">{{ $structure->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-success text-white badge-outline">Approved</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('structure.pdf', $structure->id) }}" class="btn btn-sm btn-outline btn-primary">
                                        Download PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-slate-400 italic">No approved structures available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>