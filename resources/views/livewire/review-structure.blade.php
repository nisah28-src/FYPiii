<div class="p-6 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Review Program Structure</h1>
            <span class="badge badge-lg {{ $structure->status == 'Pending' ? 'badge-warning' : 'badge-success' }}">
                Status: {{ $structure->status }}
            </span>
        </div>

        @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

       

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 p-6">
            
            <div class="md:col-span-4">
                <div class="bg-white p-6 rounded-lg shadow-md sticky top-6">
                    <h2 class="text-lg font-bold text-slate-700 mb-4">Structure Details</h2>
                    <p><span class="font-semibold">Structure Name:</span> {{ $structure->program_structure_name }}</p>
                    <p><span class="font-semibold">Created At:</span> {{ $structure->created_at->format('d M Y, H:i') }}</p>

            <div class="space-y-4">
                        <div>
                    <label class="block text-sm font-medium">HOD Remarks</label>
                    <textarea wire:model="remarks" class="w-full border rounded p-2" rows="4"></textarea>
                </div>

                <div class="flex flex-col gap-3 mt-4">
                    <button wire:click="approve" class="btn btn-success">
                     Approve Structure
                    </button>
                    <button wire:click="reject" class="btn btn-error">
                    Reject Structure
                    </button>
                </div>
            </div>
</div>
</div>
</div>

                    

            <div class="md:col-span-8">
                <div class=" bg-white p-6 rounded-lg shadow-md">
                    <div class="card-body">
                        <h2 class="text-xl font-bold text-slate-800 mb-6 border-b pb-4">
                            Structure Name: {{ $structure->program_structure_name }}
                        </h2>

                        <div class="space-y-10">
                            {{-- Grouping data mengikut Semester Number --}}
                            @foreach($structure->programSubjects->groupBy('semester_number') as $semNum => $subs)
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <div class="flex justify-between items-center mb-3">
                                        <h3 class="text-lg font-bold text-primary italic">Semester {{ $semNum }}</h3>
                                        <span class="text-sm font-medium text-slate-500">
                                            {{ $subs->count() }} Subjects
                                        </span>
                                    </div>

                                    <div class="overflow-x-auto bg-white rounded-lg shadow-sm">
                                        <table class="table w-full">
                                            <thead class="bg-slate-200 text-slate-700">
                                                <tr>
                                                    <th class="w-24">Code</th>
                                                    <th>Course Name</th>
                                                    <th class="text-center w-20">Credit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($subs as $pSub)
                                                    <tr class="hover">
                                                        <td class="font-mono font-bold text-slate-600">
                                                            {{ $pSub->subject->subject_code }}
                                                        </td>
                                                        <td class="text-slate-800">
                                                            {{ $pSub->subject->subject_name }}
                                                        </td>
                                                        <td class="text-center font-semibold">
                                                            {{ $pSub->subject->credit_hours }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-slate-50 font-bold">
                                                <tr>
                                                    <td colspan="2" class="text-right">Total Semester Credits:</td>
                                                    <td class="text-center text-primary">
                                                        {{ $subs->sum(fn($item) => $item->subject->credit_hours) }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total Keseluruhan --}}
                        <div class="mt-8 p-6 bg-primary text-primary-content rounded-2xl flex justify-between items-center shadow-lg">
                            <span class="text-lg font-bold uppercase tracking-wider">Total Program Credits</span>
                            <span class="text-3xl font-black">
                                {{ $structure->programSubjects->sum(fn($item) => $item->subject->credit_hours) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>