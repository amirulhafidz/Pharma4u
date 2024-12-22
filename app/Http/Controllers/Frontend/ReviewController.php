<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;

class ReviewController extends Controller
{
    public function StoreReview(Request $request){
        $client = $request->client_id;


        $request->validate([
            'comment' => 'required'
        ]);

        Review::insert([
            'client_id' => $client,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->rating,
            'created_at' => Carbon::now(),
            

        ]);

        $notification = array(
            'message' => 'Review will be approved by Admin',
            'alert-type' => 'success'
        );
        $previousUrl = $request->headers->get('referer');
        $redirectUrl = $previousUrl ? $previousUrl . '#pills-reviews' : 
        route('phm.details', ['id' => $client]) . '#pills-reviews';
        return redirect()->to($redirectUrl)->with($notification);
    }

    public function AdminPendingReview(){
        $pendingReview = Review::where('status',0)->orderBy('id','desc')
        ->get();
        return view('admin.backend.review.view_pending_review',
        compact('pendingReview'));
    }

    public function AdminApproveReview()
    {
        $approveReview = Review::where('status', 1)->orderBy('id', 'desc')
            ->get();
        return view(
            'admin.backend.review.view_approve_review',
            compact('approveReview')
        );
    }

    public function ReviewChangeStatus(Request $request)
    {
        $review = Review::find($request->review_id);
        $review->status = $request->status;
        $review->save();
        return response()->json(['success' => 'Status Change Succesfully']);
    }

    public function ClientPendingReview(){

        $clientId = Auth::guard('client')->id();
        $pendingReview = 
        Review::where('status', 0)
        ->where('client_id', $clientId)
        ->orderBy('id', 'desc')
        ->get();
        return view(
            'client.backend.review.view_pending_review',
            compact('pendingReview')
        );
    }

    public function ClientApproveReview()
    {
        $clientId = Auth::guard('client')->id();
        $approveReview = Review::where('status', 1)
        ->where('client_id', $clientId)
        ->orderBy('id', 'desc')
        ->get();
        return view(
            'client.backend.review.view_approve_review',
            compact('approveReview')
        );
    }
}
