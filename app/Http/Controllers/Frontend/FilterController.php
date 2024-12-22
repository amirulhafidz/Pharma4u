<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Unit;
use App\Models\Wishlist;
use App\Models\Review;
class FilterController extends Controller
{
    public function ListPharmacy(){
        $units = Unit::all();
        return view('frontend.list_pharmacy',compact('units'));
    }
    //endd

    public function FilterUnit(Request $request)
    {
        // Log::info('request data', $request->all());

        $categoryId = $request->input('categorys');
        $cityId = $request->input('citys');
        $productId = $request->input('products');
        $units =Unit::query();
        if ($categoryId){
            $units->whereIn('category_id', $categoryId);
        }
        if ($cityId) {
            $units->whereIn('city_id', $cityId);
        }
        if ($productId) {
            $units->whereIn('product_id', $productId);
        }

        $filterUnits = $units->get();

        return view('frontend.unit_list', compact('filterUnits'))
        ->render();
    }
    //endd
}
