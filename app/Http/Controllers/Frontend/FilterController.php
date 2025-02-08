<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;use App\Models\Wishlist;
use App\Models\Review;
use App\Http\Controllers\HomeController;

class FilterController extends Controller
{
    public function ListPharmacy(){
        $units = Unit::all();
        return view('frontend.list_pharmacy',compact('units'));
    }
    //endd

  


    //endd

    public function FilterUnit(Request $request)
    {
        // Log::info('request data', $request->all());

        $categoryId = $request->input('categorys');
        $cityId = $request->input('citys');
        $clientId = $request->input('clients');
        $units =Unit::query();
        if ($categoryId){
            $units->whereIn('category_id', $categoryId);
        }
        if ($cityId) {
            $units->whereIn('city_id', $cityId);
        }
        if ($clientId) {
            $units->whereIn('client_id', $clientId);
        }

        $filterUnits = $units->get();

        return view('frontend.unit_list', compact('filterUnits'))
        ->render();
    }
    //end method

    public function ViewAll($client_id, $category_id, Request $request)
    {
        $currentUserId = Auth::id(); // Get the current user ID (null if guest)

        // Fetch units that belong to the selected pharmacy (client_id) and category (category_id)
        $units = Unit::where('client_id', $client_id);
        $client = $request->client_id;

        // Units based on selected category
        $unitsSelect = Unit::where('client_id', $client_id)
            ->where('category_id', $category_id); // Filter by category

        // Apply filters if any are selected
        if ($request->has('categories')) {
            $unitsSelect->whereIn('category_id', $request->categories);
        }

        if ($request->has('products')) {
            $unitsSelect->whereIn('product_id', $request->products);
        }

        // Get all categories and products for the filter sidebar
        $categories = Category::whereHas('units', function ($query) use ($client_id) {
            $query->where('client_id', $client_id);
        })->get();

        $products = Product::whereHas('units', function ($query) use ($client_id) {
            $query->where('client_id', $client_id);
        })->get();

        // Fetch the filtered units
        $units = $units->get();
        $unitsSelect = $unitsSelect->get();

        // Collaborative Filtering Algorithm
        if ($currentUserId) {
            // If the user is logged in, perform CF based on user ratings
            $userRatedUnits = DB::table('ratings')
                ->where('user_id', $currentUserId)
                ->pluck('unit_id'); // Get the units rated by the current user

            $similarUsers = DB::table('ratings as r1')
                ->join('ratings as r2', 'r1.unit_id', '=', 'r2.unit_id')
                ->where('r1.user_id', '<>', $currentUserId) // Exclude the current user
                ->whereIn('r1.unit_id', $userRatedUnits) // Only consider units rated by the current user
                ->pluck('r2.user_id'); // Get all users who rated the same units

            $recommendedUnits = DB::table('ratings as r1')
                ->join('units as u', 'r1.unit_id', '=', 'u.id') // Join with units to filter by category
                ->whereIn('r1.user_id', $similarUsers) // Look at ratings from similar users
                ->whereNotIn('r1.unit_id', $userRatedUnits) // Exclude units already rated by the current user
                ->where('u.category_id', $category_id) // Filter by category
                ->where('u.client_id', $client_id) // Ensure it’s from the correct pharmacy
                ->select('r1.unit_id', DB::raw('AVG(r1.rating) as avg_rating')) // Calculate the average rating
                ->groupBy('r1.unit_id')
                ->orderByDesc('avg_rating') // Sort by highest average rating
                ->take(5) // Limit to top 5 recommendations
                ->get();
        } else {
            // If the user is a guest, recommend popular items based on ratings in that category
            $recommendedUnits = DB::table('ratings')
                ->join('units as u', 'ratings.unit_id', '=', 'u.id') // Join units table to get category_id
                ->select('ratings.unit_id', DB::raw('AVG(ratings.rating) as avg_rating'))
                ->where('u.category_id', $category_id) // Filter by category_id from the units table
                ->where('u.client_id', $client_id) // Ensure it’s from the correct pharmacy
                ->groupBy('ratings.unit_id')
                ->orderByDesc('avg_rating') // Sort by average rating
                ->take(5) // Limit to top 5 recommendations
                ->get();
        }

        // Fetch the recommended unit details based on CF results
        $recommendedUnitIDs = $recommendedUnits->pluck('unit_id');
        $recommendedUnits = Unit::whereIn('id', $recommendedUnitIDs)->get();

        return view('frontend.view_more', compact('units', 'unitsSelect', 'categories', 'products', 'client', 'recommendedUnits'));
    }


    public function FilterUnitSelect(Request $request)
    {
        $categoryId = $request->input('categories'); // Categories filter
        $productId = $request->input('products'); // Products filter
        $clientId = $request->input('client_id'); // Get the selected pharmacy ID

        // Start the base query for units
        $units = Unit::where('client_id', $clientId);

        // Apply filters if any are selected
        if ($categoryId) {
            $units->whereIn('category_id', $categoryId);
        }
        if ($productId) {
            $units->whereIn('product_id', $productId);
        }

        // Get the filtered units
        $filterUnits = $units->get();

        // Return the filtered units view (render the list)
        return view('frontend.unit_list', compact('filterUnits', 'clientId'))->render();
    }


    //end method

    public function SearchUnits(Request $request)
    {
        $query = $request->input('query');

        // Search units by name or other fields
        $units = Unit::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%')
            ->get();

        // Return results to a view
        return view('frontend.list_pharmacy', compact('units', 'query'));
    }

}
