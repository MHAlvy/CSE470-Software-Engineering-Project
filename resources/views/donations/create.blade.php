<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post a Donation</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('donations.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title') }}" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="category" :value="__('Category')" />
                        <select id="category" name="category" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food</option>
                            <option value="Clothes" {{ old('category') == 'Clothes' ? 'selected' : '' }}>Clothes</option>
                            <option value="Medicine" {{ old('category') == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                            <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Upload Image (Optional)')" />
                        <input id="image" type="file" name="image" class="block mt-1 w-full" accept="image/*">
                    </div>

                    <x-primary-button>Post Donation</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>