<?php

namespace App\Http\Controllers;

use App\Models\DonationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationItemController extends Controller
{
    public function create()
    {
        return view('donations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:Food,Medicine,Clothes,Other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('donations', 'public');
        }

        DonationItem::create([
            'donor_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image_url' => $imagePath,
            'expires_at' => $request->category === 'Food' ? now()->addHours(24) : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Donation posted successfully!');
    }
}