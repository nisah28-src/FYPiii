<div>
    {{-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison --}}

    <h2 class="text-2xl"> Review Structure</h2>

    <h3> Structure Name: (Dummy) BIT Structure 1</h3>
    


    <div>
<button class="btn btn-success">Approve</button>
<button class="btn btn-error">Reject</button>

</div>
    <div class="max-h-[500px] max-w-[700px] overflow-y-auto">
        <div class="card bg-slate-200 border border-base-300 m-4">
           @foreach($structure as $semester)

<div class="card bg-slate-200 border border-base-300 m-4">
    <div class="card-body shadow-md">

        <h2 class="font-semibold">
            Semester {{ $semester['semester'] }}
        </h2>

        <div class="overflow-x-auto mt-3">
            <table class="table table-zebra w-full text-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Credit</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($semester['subs'] as $sub)
                    <tr>
                        <td>{{ $sub->subject_name }}</td>
                        <td>{{ $sub->subject_code }}</td>
                        <td>{{ $sub->credit_hours }}</td>
                        <td>
                            <button class="btn btn-error btn-xs">
                                Remove
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-right text-primary font-semibold mt-2">
            Total Credit:
            {{ collect($semester['subs'])->sum(fn($sub) => $sub->credit_hours) }}
        </div>

    </div>
</div>

@endforeach
        </div>
</div>

<textarea class="textarea textarea-bordered mt-4" placeholder="Add comment..."></textarea>
<button>Save Comment</button>

</div>
