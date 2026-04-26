<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Add New Subject</h2>
        
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">Subject Name</label>
                <input type="text" wire:model="subject_name" class="w-full border rounded p-2">
                @error('subject_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">Subject Code</label>
                <input type="text" wire:model="subject_code" class="w-full border rounded p-2">
                @error('subject_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">Credit Hours</label>
                <input type="number" wire:model="credit_hours" class="w-full border rounded p-2">
                @error('credit_hours') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Subject</button>
            </div>
        </form>
    </div>
</div>