<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Requests for: {{ $donation->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="font-bold text-lg mb-4">Pending Requests</h3>

                @if($claims->isEmpty())
                    <p class="text-gray-500">No one has requested this item yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($claims as $claim)
                            <div class="p-4 border rounded-md {{ $claim->status === 'Approved' ? 'bg-green-50 border-green-200' : 'bg-gray-50' }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $claim->receiver->name }}</p>
                                        <p class="text-sm text-gray-600 mt-1"><strong>Reason:</strong> {{ $claim->justificationNote }}</p>
                                        <p class="text-xs text-gray-500 mt-2">Requested: 
                                        @if($claim->status === 'Approved')
                                            <div class="mt-3 p-3 bg-white border border-green-200 rounded text-sm">
                                                <p class="text-green-700 font-bold mb-1">Contact Receiver:</p>
                                                <p><strong>Phone:</strong> {{ $claim->receiver->phone }}</p>
                                                <p><strong>Location:</strong> {{ $claim->receiver->locationCoordinates }}</p>
                                            </div>
                                        @endif    
                                    </div>
                                    
                                    <div>
                                        @if($donation->status === 'Available')
                                            <form method="POST" action="{{ route('claims.approve', $claim->id) }}">
                                                @csrf
                                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-semibold">
                                                    Approve Request
                                                </button>
                                            </form>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $claim->status === 'Approved' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $claim->status }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>