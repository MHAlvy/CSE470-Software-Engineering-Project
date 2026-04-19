<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Community Donation Feed') }}
            </h2>
            <div>
                @if(Auth::user()->role === 'donor')
                    <a href="{{ route('donations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        + Post Donation
                    </a>
                @endif
                @if(Auth::user()->role === 'receiver')
                    <a href="{{ route('claims.my') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        My Claims
                    </a>
                @endif
                @if(Auth::user()->role === 'volunteer')
                    <a href="{{ route('deliveries.index') }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">
                        Logistics Dashboard
                    </a>
                @endif
            </div>
        </div>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($donations as $donation)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                        @if($donation->image_url)
                            <img src="{{ asset('storage/' . $donation->image_url) }}" alt="Item" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                No Image Available
                            </div>
                        @endif
                        
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $donation->title }}</h3>
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                        {{ $donation->category }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($donation->description, 100) }}</p>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-700">By: {{ $donation->donor->name }}</span>
                                    <span class="text-yellow-500 text-xs mt-1">
                                        @if($donation->donor->average_rating > 0)
                                            ⭐ {{ $donation->donor->average_rating }} / 5.0
                                        @else
                                            <span class="text-gray-400">No ratings yet</span>
                                        @endif
                                    </span>
                                </div>
                                <span>{{ $donation->created_at->diffForHumans() }}</span>
                                @if(Auth::user()->role === 'receiver')
                                 <div class="mt-4">
                                    <a href="{{ route('claims.create', $donation->id) }}" class="block w-full text-center bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-semibold transition">
                                        Request to Claim
                                    </a>
                                 </div>
                                @endif
                                @if(Auth::user()->id === $donation->donor_id && $donation->status === 'Available')
                                 <div class="mt-4">
                                    <a href="{{ route('claims.index', $donation->id) }}" class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold transition">
                                        View Requests
                                     </a>
                                 </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
                        No donations are currently available in your area.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>