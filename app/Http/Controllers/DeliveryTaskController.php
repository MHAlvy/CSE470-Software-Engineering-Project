<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTask;
use App\Models\DonationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryTaskController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'volunteer') {
            abort(403);
        }

        $availableTasks = DonationItem::where('status', 'Claimed')
            ->doesntHave('deliveryTask')
            ->with('donor', 'claimRequests.receiver')
            ->get();

        $myTasks = DeliveryTask::where('volunteer_id', Auth::id())
            ->whereIn('status', ['Pending', 'Picked Up'])
            ->with('donation.donor', 'donation.claimRequests.receiver')
            ->get();

        return view('deliveries.index', compact('availableTasks', 'myTasks'));
    }

    public function accept(DonationItem $donation)
    {
        if (Auth::user()->role !== 'volunteer' || $donation->status !== 'Claimed') {
            abort(403);
        }

        DeliveryTask::create([
            'donation_id' => $donation->id,
            'volunteer_id' => Auth::id(),
            'status' => 'Pending',
        ]);

        $donation->update(['status' => 'In Transit']);

        return redirect()->route('deliveries.index')->with('success', 'You have successfully assigned yourself to this delivery task!');
    }

    public function updateStatus(Request $request, DeliveryTask $delivery)
    {
        if (Auth::id() !== $delivery->volunteer_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Picked Up,Delivered',
        ]);

        $delivery->update([
            'status' => $request->status,
            'pickedUpAt' => $request->status === 'Picked Up' ? now() : $delivery->pickedUpAt,
            'deliveredAt' => $request->status === 'Delivered' ? now() : $delivery->deliveredAt,
        ]);

        return redirect()->route('deliveries.index')->with('success', 'Delivery status updated successfully!');
    }
}