<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Client;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
class RatingController extends Controller
{

    //chatgpt made Rating function, others are by me
    public function Rating($id)
    {
        // SQL Query Logic
        $ratings = DB::table('ratings as r1')
            ->join('ratings as r2', function ($join) {
                $join->on('r1.user_id', '=', 'r2.user_id')
                    ->whereColumn('r1.unit_id', '<>', 'r2.unit_id');
            })
            ->where('r1.unit_id', $id)
            ->select(
                'r2.unit_id as recommended_unit',
                DB::raw('SUM(r1.rating * r2.rating) as dot_product'),
                DB::raw('SQRT(SUM(r1.rating * r1.rating)) as magnitude_target'),
                DB::raw('SQRT(SUM(r2.rating * r2.rating)) as magnitude_compared')
            )
            ->groupBy('r2.unit_id')
            ->orderByDesc(DB::raw('SUM(r1.rating * r2.rating) / (SQRT(SUM(r1.rating * r1.rating)) * SQRT(SUM(r2.rating * r2.rating)))'))
            ->take(5) // Limit ratings
            ->get();

        return response()->json($ratings);
    }

    public function RatingView($id)
    {
        $client = Client::find($id);
        $unit = Unit::find($id);
        $reviews = Rating::where('unit_id', $unit->id)->get();
        $totalReviews = $reviews->count();
        $ratingSum = $reviews->sum('rating');
        $averageRating = $totalReviews > 0 ? $ratingSum / $totalReviews : 0;
        $roundedAverageRating = round($averageRating, 1);

        // Get recommended units based on collaborative filtering
        $recommendedUnits = DB::table('ratings as r1')
            ->join('ratings as r2', function ($join) {
                $join->on('r1.user_id', '=', 'r2.user_id')
                    ->whereColumn('r1.unit_id', '<>', 'r2.unit_id');
            })
            ->where('r1.unit_id', $unit->id)
            ->select(
                'r2.unit_id as recommended_unit',
                DB::raw('SUM(r1.rating * r2.rating) as dot_product'),
                DB::raw('SQRT(SUM(r1.rating * r1.rating)) as magnitude_target'),
                DB::raw('SQRT(SUM(r2.rating * r2.rating)) as magnitude_compared')
            )
            ->groupBy('r2.unit_id')
            ->orderByDesc(DB::raw('SUM(r1.rating * r2.rating) / (SQRT(SUM(r1.rating * r1.rating)) * SQRT(SUM(r2.rating * r2.rating)))'))
            ->take(5)
            ->get();

        // Fetch the recommended units by their IDs
        $recommendedUnitsList = Unit::whereIn('id', $recommendedUnits->pluck('recommended_unit'))->get();
        
        return view(
            'frontend.unit_details_page',
            compact(
                'unit',
                'client',
                'reviews',
                'roundedAverageRating',
                'totalReviews',
                'recommendedUnitsList'
            )
        );
    }


    public function LeaveRating($id)
    {
        $unit = Unit::find($id);
        $client = Client::find($id);
        $unit = Unit::find($id);
        $reviews = Rating::where('unit_id', $unit->id)->get();
        $totalReviews = $reviews->count();
        $ratingSum = $reviews->sum('rating');
        $averageRating = $totalReviews > 0 ? $ratingSum / $totalReviews : 0;
        $roundedAverageRating = round($averageRating, 1);

        $ratingCounts = [
            '5' => $reviews->where('rating', 5)->count(),
            '4' => $reviews->where('rating', 4)->count(),
            '3' => $reviews->where('rating', 3)->count(),
            '2' => $reviews->where('rating', 2)->count(),
            '1' => $reviews->where('rating', 1)->count(),
        ];
        $ratingPercentages = array_map(function ($count) use ($totalReviews) {
            return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }, $ratingCounts);

        if (Auth::check()) {
            $cart = session()->get('cart', []);
            $totalAmount = 0;
            foreach ($cart as $car) {
                $totalAmount += $car['price'];
            }
            if ($totalAmount >= 0) {
                return view(
                    'frontend.unit_details_page',
                    compact(
                        'unit',
                        'client',
                        'reviews',
                        'roundedAverageRating',
                        'totalReviews',
                        'ratingCounts',
                        'ratingPercentages'
                    )
                );
            } 
        } else {
            
            return redirect()->route('login');
        }
    }






    public function StoreRating(Request $request)
    {
        // $client = $request->client_id;
        $unit = $request->unit_id;


        $request->validate([
            'comment' => 'required'
        ]);

        Rating::insert([
            'user_id' => Auth::id(),
            // 'client_id' => $client,
            'unit_id' => $unit,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'created_at' => Carbon::now(),


        ]);

        $notification = array(
            'message' => '  Rating will be approved by Admin',
            'alert-type' => 'success'
        );
        $previousUrl = $request->headers->get('referer');
        $redirectUrl = $previousUrl ? $previousUrl . '#pills-reviews' :
            route('frontend.unit_details_page', ['id' => $unit]) . '#pills-reviews';
        return redirect()->to($redirectUrl)->with($notification);
    }
}

