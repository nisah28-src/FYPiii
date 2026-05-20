 <x-app-layout>
    <div class="p-6 space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">Academic Programs</h1>
            <label for="add-program-modal" class="btn btn-accent"> Add New Program</label>
        </div>

        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <table class="table table-zebra w-full bg-base-100">
                    <thead>
                        <tr>
                            <th>Program Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $program)
                        <tr>
                            <td>{{ $program->program_name }}</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>
                                <button class="btn btn-xs btn-outline btn-error">Remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <input type="checkbox" id="add-program-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Add New Program</h3>
                <form action="{{ route('programs.store') }}" method="POST" class="py-4 space-y-4">
                    @csrf
                    <div class="form-control">
                        <label class="label">Program Name</label>
                        <input type="text" id="program_name" name="program_name" class="input input-bordered" placeholder="e.g. Bachelor of ..." required />
                    </div>
                    <div class="modal-action">
                        <label for="add-program-modal" class="btn">Cancel</label>
                        <button type="submit" class="btn btn-primary">Save Program</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>