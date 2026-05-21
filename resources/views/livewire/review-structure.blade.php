<div class="p-6 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Review Program Structure</h1>
            <span class="badge badge-lg {{ $structure->status == 'pending' ? 'badge-warning' : 'badge-success' }}">
                Status: {{ ucfirst($structure->status) }}
            </span>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success mb-4">{{ session('message') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <div class="md:col-span-4 lg:col-span-3">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 sticky top-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Action Panel</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-slate-500">Structure Name:</p>
                            <p class="font-semibold text-slate-800">{{ $structure->program_structure_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Submitted At:</p>
                            <p class="font-semibold text-slate-800">{{ $structure->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        
                        <div class="pt-4 border-t">
                            <label class="block text-sm font-medium mb-2">HOD Remarks</label>
                            <textarea wire:model="remarks" class="textarea textarea-bordered w-full" rows="4" placeholder="Enter review comments..."></textarea>
                        </div>

                        <div class="flex flex-col gap-2 pt-2">
                            <button wire:click="approve" class="btn btn-success  w-full">Approve Structure</button>
                            <button wire:click="reject" class="btn btn-error  w-full">Reject Structure</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-8 lg:col-span-9">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                    <h2 class="text-xl font-bold text-slate-800 mb-8 pb-4 border-b">
                        Structure: {{ $structure->program_structure_name }}
                    </h2>

                    <div class="space-y-10">
                        @foreach($structure->programSubjects->groupBy('semester_number') as $semNum => $subs)
                            <div class="border border-slate-100 rounded-xl bg-slate-50 p-5">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-bold text-primary italic">Semester {{ $semNum }}</h3>
                                    <span class="badge badge-ghost">{{ $subs->count() }} Subjects</span>
                                </div>
                                
                                <div class="overflow-x-auto bg-white rounded-lg border">
                                    <table class="table w-full">
                                        <thead class="bg-slate-100">
                                            <tr>
                                                <th>Code</th>
                                                <th>Course Name</th>
                                                <th>Credit</th>
                                                <th>Prerequisites</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($subs as $pSub)
                                                <tr>
                                                    <td class="font-mono font-medium">{{ $pSub->subject_code_snapshot }}</td>
                                                    <td>{{ $pSub->subject_name_snapshot }}</td>
                                                    <td>{{ $pSub->credit_hours_snapshot }}</td>
                                                    <td>
                                                        {{ !empty($pSub->prerequisites) ? implode(', ', $pSub->prerequisites) : 'None' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</div>