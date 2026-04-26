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
    <form action="{{ route('subject.store') }}" method="POST"> 
@csrf 

<div class="mt-4">
            <x-input-label for="subject_name" :value="__('Subject Name')" />
            <x-text-input id="subject_name" class="block mt-1 w-full" type="text" name="subject_name" :value="old('subject_name')" />
            <x-input-error :messages="$errors->get('subject_name')" class="mt-2" />
        </div>

     <div class="mt-4">   
        <x-input-label for="subject_code" :value="__('Subject Code')" />
            <x-text-input id="subject_code" class="block mt-1 w-full" type="text" name="subject_code" :value="old('subject_code')" />
            <x-input-error :messages="$errors->get('subject_code')" class="mt-2" />
        </div>
       
        <div class="mt-4">
        <x-input-label for="credit_hours" :value="__('Credit Hour')" />
            <x-text-input id="credit_hours" class="block mt-1 w-full" type="text" name="credit_hours" :value="old('credit_hours')" />
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
            
                    @foreach ($subjects as $subject)
                     <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="subject_prerequisite[]" value="{{ $subject->id }}" class="checkbox checkbox-sm">
                        {{ $subject->subject_name }}
                    </label>  
                  
                    @endforeach
                
                </div>   
</div>
</div>
</div>


          

    <x-primary-button class="ms-4">
                {{ __('Add') }}
            </x-primary-button>
        </div>
    </form>


</x-app-layout>