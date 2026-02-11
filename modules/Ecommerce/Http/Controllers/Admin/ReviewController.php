<?php

namespace Karma\Ecommerce\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['product', 'user'])->latest()->paginate(20);
        return view('ecommerce::admin.reviews.index', compact('reviews'));
    }

    public function toggleApproval(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        return back()->with('success', 'Review status updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.ecommerce.reviews.index')->with('success', 'Review deleted successfully.');
    }
}
