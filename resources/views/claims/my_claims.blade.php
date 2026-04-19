<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Claims</h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($claims->isEmpty())
                    <p class="text-gray-500">You have not requested any items yet.</p>
                @else
                    <div class="space-y-6">
                        @foreach ($claims as $claim)
                            <div class="p-4 border rounded-md {{ $claim->status === 'Approved' ? 'border-green-400 bg-green-50' : 'bg-gray-50' }}">
                                <h3 class="font-bold text-lg">{{ $claim->donation->title }}</h3>
                                <p class="text-sm text-gray-600 mt-1">Status: 
                                    <span class="font-semibold {{ $claim->status === 'Approved' ? 'text-green-700' : '' }}">{{ $claim->status }}</span>
                                </p>

                                @if($claim->status === 'Approved')
                                    <div class="mt-4 p-4 bg-white border border-gray-200 rounded-md">
                                        <h4 class="font-semibold text-red-600 mb-2">Private Contact Details Unlocked!</h4>
                                        <p><strong>Donor Name:</strong> {{ $claim->donation->donor->name }}</p>
                                        <p><strong>Phone:</strong> {{ $claim->donation->donor->phone }}</p>
                                        <p><strong>Pickup Location:</strong> {{ $claim->donation->donor->locationCoordinates }}</p>
                                    </div>

                                    <form method="POST" action="{{ route('claims.confirm', $claim->id) }}" class="mt-4">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-semibold text-sm">
                                            Confirm Receipt & Close Transaction
                                        </button>
                                    </form>
                                @elseif($claim->status === 'Completed' && !$claim->donation->reviews()->where('reviewer_id', Auth::id())->exists())
                                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                                        <h4 class="font-semibold text-blue-800 mb-2">Rate your experience with this Donor</h4>
                                        <form method="POST" action="{{ route('reviews.store', $claim->donation->id) }}">
                                            @csrf
                                            <div class="mb-2">
                                                <select name="rating" class="border-gray-300 rounded-md shadow-sm text-sm w-full" required>
                                                    <option value="" disabled selected>Select a rating...</option>
                                                    <option value="5">⭐⭐⭐⭐⭐ (5/5) - Excellent</option>
                                                    <option value="4">⭐⭐⭐⭐ (4/5) - Good</option>
                                                    <option value="3">⭐⭐⭐ (3/5) - Average</option>
                                                    <option value="2">⭐⭐ (2/5) - Poor</option>
                                                    <option value="1">⭐ (1/5) - Terrible</option>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <textarea name="comment" rows="2" class="border-gray-300 rounded-md shadow-sm text-sm w-full" placeholder="Leave an optional comment..."></textarea>
                                            </div>
                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold text-sm">
                                                Submit Review
                                            </button>
                                        </form>
                                    </div>
                                @elseif($claim->status === 'Completed')
                                    <div class="mt-4 p-3 bg-gray-100 text-gray-600 rounded-md text-sm font-semibold">
                                        Transaction Completed & Reviewed.
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>