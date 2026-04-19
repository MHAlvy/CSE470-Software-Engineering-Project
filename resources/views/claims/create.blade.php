<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Request Item: {{ $donation->title }}</h2>
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

                <div class="mb-6 p-4 bg-gray-50 rounded-md border border-gray-200">
                    <h3 class="font-bold text-lg mb-2">Item Details</h3>
                    <p><strong>Category:</strong> {{ $donation->category }}</p>
                    <p><strong>Description:</strong> {{ $donation->description }}</p>
                    <p><strong>Donor:</strong> {{ $donation->donor->name }}</p>
                </div>

                <form method="POST" action="{{ route('claims.store', $donation->id) }}">
                    @csrf
                    
                    <div class="mb-4">
                        <x-input-label for="justificationNote" :value="__('Why do you need this item?')" />
                        <textarea id="justificationNote" name="justificationNote" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ old('justificationNote') }}</textarea>
                    </div>

                    <x-primary-button>Submit Request</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>