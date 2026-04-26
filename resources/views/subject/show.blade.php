<x-app-layout>
    <div class="container">
    <h2 class="mb-4">Subject Details</h2>

     <h4> Subject Name: {{ $subject -> subject_name }} </h4>
     <h4> Subject Code: {{ $subject -> subject_code }} </h4>
     <h4> Credit Hours: {{ $subject -> credit_hours }} </h4>
     <h4> Category: {{ $subject -> category_type }} </h4>
     <h4> Pre-Requisite: {{ $subject -> pre_requisite_id }} </h4>

</div>

<button class="btn btn-accent p-2 mt-6">Edit</button>

</x-app-layout>