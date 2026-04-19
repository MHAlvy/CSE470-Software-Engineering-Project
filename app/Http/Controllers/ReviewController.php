<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\DonationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, DonationItem $donation)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'donation_id' => $donation->id,
            'reviewer_id' => Auth::id(),
            'reviewee_id' => $donation->donor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Thank you! Your rating has been submitted.');
    }
}