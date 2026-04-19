<?php

namespace App\Http\Controllers;

use App\Models\ClaimRequest;
use App\Models\DonationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimRequestController extends Controller
{
    public function create(DonationItem $donation)
    {
        return view('claims.create', compact('donation'));
    }

    public function store(Request $request, DonationItem $donation)
    {
        $request->validate([
            'justificationNote' => 'required|string|max:1000',
        ]);

        ClaimRequest::create([
            'donation_id' => $donation->id,
            'receiver_id' => Auth::id(),
            'justificationNote' => $request->justificationNote,
            'status' => 'Pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Claim request submitted successfully!');
    }

    public function index(DonationItem $donation)
    {
        if (Auth::id() !== $donation->donor_id) {
            abort(403);
        }

        $claims = $donation->claimRequests()->with('receiver')->get();
        return view('claims.index', compact('donation', 'claims'));
    }

    public function approve(ClaimRequest $claim)
    {
        $donation = $claim->donation;

        if (Auth::id() !== $donation->donor_id) {
            abort(403);
        }

        $claim->update(['status' => 'Approved']);

        ClaimRequest::where('donation_id', $donation->id)
            ->where('id', '!=', $claim->id)
            ->update(['status' => 'Rejected']);

        $donation->update(['status' => 'Claimed']);

        return redirect()->route('dashboard')->with('success', 'Request approved successfully! The item is now marked as Claimed.');
    }

    public function myClaims()
    {
        $claims = ClaimRequest::with('donation.donor')
            ->where('receiver_id', Auth::id())
            ->latest()
            ->get();
            
        return view('claims.my_claims', compact('claims'));
    }

    public function confirm(ClaimRequest $claim)
    {
        if (Auth::id() !== $claim->receiver_id || $claim->status !== 'Approved') {
            abort(403);
        }

        $claim->update(['status' => 'Completed']);
        $claim->donation->update(['status' => 'Completed']);

        return redirect()->route('claims.my')->with('success', 'Receipt confirmed successfully! Thank you.');
    }
}