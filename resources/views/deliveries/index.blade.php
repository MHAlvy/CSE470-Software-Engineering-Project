<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Volunteer Logistics Dashboard</h2>
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
            <h3 class="text-2xl font-bold mb-4">My Active Deliveries</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border-l-4 border-yellow-500">
                @if($myTasks->isEmpty())
                    <p class="text-gray-500">You currently have no active deliveries.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($myTasks as $task)
                            @php $claim = $task->donation->claimRequests->where('status', 'Approved')->first(); @endphp
                            <div class="border p-4 rounded-md bg-gray-50">
                                <h4 class="font-bold text-lg border-b pb-2 mb-2">{{ $task->donation->title }}</h4>
                                
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 font-bold">PICKUP FROM:</p>
                                    <p class="text-sm">{{ $task->donation->donor->name }} ({{ $task->donation->donor->phone }})</p>
                                    <p class="text-sm text-red-600 font-semibold">{{ $task->donation->donor->locationCoordinates }}</p>
                                </div>

                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 font-bold">DELIVER TO:</p>
                                    <p class="text-sm">{{ $claim?->receiver?->name ?? 'Pending Receiver' }} ({{ $claim?->receiver?->phone ?? 'N/A' }})</p>
                                    <p class="text-sm text-green-600 font-semibold">{{ $claim?->receiver?->locationCoordinates ?? 'Pending Location' }}</p>
                                </div>

                                <form method="POST" action="{{ route('deliveries.update', $task->id) }}">
                                    @csrf
                                    <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm w-full mb-2">
                                        <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }} disabled>Pending</option>
                                        <option value="Picked Up" {{ $task->status === 'Picked Up' ? 'selected' : '' }}>Mark as Picked Up</option>
                                        <option value="Delivered" {{ $task->status === 'Delivered' ? 'selected' : '' }}>Mark as Delivered</option>
                                    </select>
                                    <x-primary-button class="w-full justify-center">Update Status</x-primary-button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <h3 class="text-2xl font-bold mb-4">Available Delivery Tasks</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                @if($availableTasks->isEmpty())
                    <p class="text-gray-500">No items currently need to be delivered in your area.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($availableTasks as $donation)
                            @php $claim = $donation->claimRequests->where('status', 'Approved')->first(); @endphp
                            <div class="p-4 border rounded-md flex justify-between items-center bg-gray-50">
                                <div>
                                    <h4 class="font-bold text-lg">{{ $donation->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-1"><strong>Route:</strong> {{ $donation->donor->locationCoordinates ?? 'N/A' }} ➔ {{ $claim?->receiver?->locationCoordinates ?? 'Pending Location' }}</p>
                                </div>
                                <form method="POST" action="{{ route('deliveries.accept', $donation->id) }}">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold text-sm">
                                        Accept Task
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <h3 class="text-2xl font-bold mb-4 mt-8 text-gray-800">My Delivery History</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-12">
                @php
                    $history = \App\Models\DeliveryTask::where('volunteer_id', auth()->id())
                                ->where('status', 'Delivered')
                                ->orderBy('updated_at', 'desc')
                                ->get();
                @endphp

                @if($history->isEmpty())
                    <p class="text-gray-500 text-center">You haven't completed any deliveries yet. Your successful missions will appear here!</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($history as $item)
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-md transition duration-300">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-bold text-gray-900">{{ $item->donation->title ?? 'Delivered Item' }}</h4>
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-green-200">
                                        Completed
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mb-4">
                                    Delivered on: {{ $item->updated_at->format('M d, Y') }}
                                </p>
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                    <span class="text-sm font-bold text-indigo-600">✓ Mission Accomplished</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>