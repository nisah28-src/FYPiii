<x-app-layout>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<h2 class="text-center">Add Subject</h2>
    <form action="{{ route('subject.update', $subject->id) }}" method="POST"> 
@csrf 

@method('PUT') <div class="flex justify-center mt-6">
<div class="card w-full sm:w-96 bg-base-100 shadow-2xl border border-base-300 overflow-hidden">
    <div class="card-body p-10">
    <div class="mt-4">
            <x-input-label for="subject_name" :value="__('Subject Name')" />
            <x-text-input id="subject_name" class="block mt-1 w-full" type="text" name="subject_name" :value="old('subject_name', $subject->subject_name)" />
            <x-input-error :messages="$errors->get('subject_name')" class="mt-2" />
        </div>

     <div class="mt-4">   
        <x-input-label for="subject_code" :value="__('Subject Code')" />
            <x-text-input id="subject_code" class="block mt-1 w-full" type="text" name="subject_code" :value="old('subject_code', $subject->subject_code)" />
            <x-input-error :messages="$errors->get('subject_code')" class="mt-2" />
        </div>
       
        <div class="mt-4">
        <x-input-label for="credit_hours" :value="__('Credit Hour')" />
            <x-text-input id="credit_hours" class="block mt-1 w-full" type="text" name="credit_hours" :value="old('credit_hours', $subject->credit_hours)" />
            <x-input-error :messages="$errors->get('credit_hours')" class="mt-2" />
        </div>

        <div class="mt-4">
        <x-input-label for="category_type" :value="__('Subject Type')" />
            <select name="category_type" class="form-control">
    @foreach(App\Enums\SubjectStatus::cases() as $type)
        <option value="{{ $type->value }}" 
        @selected(old('category_type', $subject->category_type->value ?? '') == $type->value)>
            {{ $type->label() }} 
        </option>
    @endforeach
    </select>

        <div class="mt-4">
            <x-input-label for="subject_prerequisite" :value="__('Pre-Requisite')" />
                <div class="max-h-[150px] w-full border overflow-y-auto">
            
                    
                     <label class="flex items-center gap-2 cursor-pointer">
                        <select class="form-control select2-search" name="subject_prerequisite[]" multiple="multiple">
                        @foreach ($subjects as $sub)  
                        @if ($sub->id != $subject->id)  
                        <option value="{{ $sub->id }}" 
                            @selected(in_array($sub->id, old('subject_prerequisite', $subject->prerequisites->pluck('id')->toArray() ?? [])))>
                                {{ $sub->subject_code }} - 
                        {{ $sub->subject_name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </label>
                
                </div>   
        </div>
    </div>
    </div>        
</div>
</div>
        <div class="flex justify-center mt-6">

    <x-primary-button class="ms-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
<script>
$(document).ready(function() {
    // Aktifkan fungsi carian pada dropdown
    $('.select2-search').select2({
        placeholder: "Taip kod atau nama subjek...",
        allowClear: true,
        width: '100%' // Supaya ikut lebar container
    });
});
</script>

</x-app-layout>