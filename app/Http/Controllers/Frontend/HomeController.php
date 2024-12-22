<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Wishlist;
use App\Models\Review;

use Illuminate\Support\Facades\DB;





class HomeController extends Controller
{
    public function PharmacyDetails($id)
    {
        $client = Client::find($id);
        $products = Product::where('client_id', $client->id)->get()->filter(function ($product) {
            return $product->units->isNotEmpty();
        });

        $galleri = Gallery::where('client_id', $id)->get();
        $reviews = Review::where('client_id', $client->id)
            ->where('status', 1)->get();
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

        // Add the recommended units fetching logic here
        $recommendedUnits = DB::table('ratings as r1')
            ->join('ratings as r2', function ($join) {
                $join->on('r1.user_id', '=', 'r2.user_id')
                    ->whereColumn('r1.unit_id', '<>', 'r2.unit_id');
            })
            ->where('r1.unit_id', $products->first()->unit_id) // Assuming you have a unit_id
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

        return view('frontend.details_page', compact(
            'client',
            'products',
            'galleri',
            'reviews',
            'roundedAverageRating',
            'totalReviews',
            'ratingCounts',
            'ratingPercentages',
            'recommendedUnitsList'
        ));
    }


    public function AddWishList(Request $request, $id){
        if (Auth::check()){
            $exists = Wishlist::where('user_id', Auth::id())
            ->where('client_id', $id)->first();    
            
            if (!$exists){
                Wishlist::insert([
                    'user_id'=>Auth::id(),
                    'client_id' => $id,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json(['success' => 'Your Wishlist added successfully do']);
            }
            else{
                return response()->json(['error' => 'Kat Wishlist dah ada do']);
            }

        }
        else{
            return response()->json(['error' => 'Login dulu do To Use This Feature']);
        }
    }


    public function AllWishList(){
        $wishlist =  Wishlist::where('user_id', Auth::id())->get();
        return view('frontend.dashboard.all_wishlist', compact ('wishlist'));
    }

    public function RemoveWishList($id)
    {
    Wishlist::find($id)->delete();

        $notification = array(
            'message' => 'Wishlist Removed Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function ViewUnit($id){
        $client = Client::find($id);
        $unit = Unit::find($id);
        $reviews = Review::where('client_id', $client->id)
            ->where('status', 1)->get();
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
        return view(
            'frontend.unit_details_page', compact('unit','client',
                'reviews',
                'roundedAverageRating',
                'totalReviews',
                'ratingCounts',
                'ratingPercentages'));
    }


}
