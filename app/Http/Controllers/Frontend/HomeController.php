<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Wishlist;
use App\Models\Review;
use App\Models\Rating;

use Illuminate\Support\Facades\DB;





class HomeController extends Controller
{
    public function PharmacyDetails($id)
    {
        $client = Client::find($id);
        $products = Product::where('client_id', $client->id)->get()->filter(function ($product) {
            return $product->units->isNotEmpty();
        });
        $categories = Category::with('units')->get();

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

        // Fetch recommended units using the Rating function
        $ratings = DB::table('ratings as r1')
            ->join('ratings as r2', function ($join) {
                $join->on('r1.user_id', '=', 'r2.user_id')
                    ->whereColumn('r1.unit_id', '<>', 'r2.unit_id');
            })
            ->where('r1.unit_id', $id)
            ->where('r2.client_id', $client->id) // Specify the table and use $client->id
            ->select('r2.unit_id as recommended_unit')
            ->groupBy('r2.unit_id')
            ->take(3) // Limit to 5 recommendations
            ->get();


        // Fetch the actual unit details
        $recommendedUnitIDs = $ratings->pluck('recommended_unit');
        $recommendedUnits = Unit::whereIn('id', $recommendedUnitIDs)->get();


        return view('frontend.details_page', compact(
            'client',
            'categories',
            'products',
            'galleri',
            'reviews',
            'roundedAverageRating',
            'totalReviews',
            'ratingCounts',
            'ratingPercentages',
            'recommendedUnits'
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
        $rating = Rating::where('unit_id', $unit->id)
            ->where('status', 1)->get();
        $totalReviews = $rating->count();
        $ratingSum = $rating->sum('rating');
        $averageRating = $totalReviews > 0 ? $ratingSum / $totalReviews : 0;
        $roundedAverageRating = round($averageRating, 1);

        $ratingCounts = [
            '5' => $rating->where('rating', 5)->count(),
            '4' => $rating->where('rating', 4)->count(),
            '3' => $rating->where('rating', 3)->count(),
            '2' => $rating->where('rating', 2)->count(),
            '1' => $rating->where('rating', 1)->count(),
        ];
        $ratingPercentages = array_map(function ($count) use ($totalReviews) {
            return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }, $ratingCounts);
        return view(
            'frontend.unit_details_page', compact('unit','client',
                'rating',
                'roundedAverageRating',
                'totalReviews',
                'ratingCounts',
                'ratingPercentages'));
    }

    public function AllList(){
        return view('frontend.all_list_pharmacy');
    }


}
