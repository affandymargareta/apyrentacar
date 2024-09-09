<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;

class RatingController extends Controller
{
    //
    public function store(Request $request, Product $product)
    {
        // Validate the request inputs
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Store the review
        Rating::create([
            'product_id' => 'v2'. '-' .$product->id,
            'user_id' => Auth::id(), // Ensure the user is authenticated
            'comment' => $request->comment,
            'rating' => $request->rating, 
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
    public function show(Product $product)
    {
        // Get all reviews for the product
        $reviews = $product->ratings;

        // Calculate the average rating
        $averageRating = $reviews->avg('rating');

        return view('products.show', compact('product', 'reviews', 'averageRating'));
    }
}
