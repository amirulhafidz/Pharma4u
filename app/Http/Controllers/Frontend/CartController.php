<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;


class CartController extends Controller
{
    public function AddToCart($id)
    {

        if(Session::has('coupon')) {
            Session::forget('coupon');
        }
        $units = Unit::find($id);
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $pricetoShow = isset($units->discount_price) ?
                $units->discount_price : $units->price;
            $cart[$id] = [
                'id' => $id,
                'name' => $units->name,
                'image' => $units->image,
                'price' => $pricetoShow,
                'client_id' => $units->client_id,
                'quantity' => 1
            ];
        }
        session()->put('cart', $cart);

        //return response()->json($cart);
        $notification = array(
            'message' => 'Added to Cart Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    }
    //End methodd

    public function updateCartQuatity(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return response()->json([
            'message' => 'Quantity Updated',
            'alert-type' => 'success'
        ]);

    }
    //End methodd

    public function CartRemove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        return response()->json([
            'message' => 'Cart Removed Successfully',
            'alert-type' => 'success'
        ]);

    }

    public function ApplyCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_name', $request->coupon_name)
            ->where('validity', '>=', Carbon::now()->format('Y-m-d'))->first();

        $cart = session()->get('cart', []);
        $totalAmount = 0;
        $clientIds = [];

        foreach ($cart as $car) {
            $totalAmount += ($car['price'] * $car['quantity']);
            $pd = Unit::find($car['id']);
            $clid = $pd->client_id;
            array_push($clientIds, $clid);
        }

        if ($coupon) {
            if (count(array_unique($clientIds)) === 1) {
                $cvendorId = $coupon->client_id;

                if ($cvendorId == $clientIds[0]) {
                    Session::put('coupon', [
                        'coupon_name' => $coupon->coupon_name,
                        'discount' => $coupon->discount,
                        'discount_amount' => $totalAmount - ($totalAmount * $coupon->discount / 100),
                    ]);
                    $couponData = Session()->get('coupon');

                    return response()->json(array(
                        'validity' => true,
                        'success' => 'Coupon Applied Successfully',
                        'couponData' => $couponData,
                    ));
                } else {
                    return response()->json(['error' => 'This Coupon Not Valid for this Pharmacy']);
                }

            } else {
                return response()->json(['error' => 'This Coupon for one of the selected Pharmacy']);
            }
        } else {
            return response()->json(['error' => 'Invalid Coupon']);
        }
    }

    //end

    public function RemoveCoupon(){
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Removed Successfully']);
    }
    //end

    public function PharmCheckout(){
        if (Auth::check()) {
            $cart = session()->get('cart', []);
            $totalAmount = 0;
            foreach ($cart as $car) {
                $totalAmount += $car['price'];
            }
            if ($totalAmount > 0) {
                return view('frontend.checkout.view_checkout', compact('cart'));
            } else {
                $notification = array(
                    'message' => 'Shopping at list one item',
                    'alert-type' => 'error'
                );
                return redirect()->to('/')->with($notification);
            }

        } else {
            $notification = array(
                'message' => 'Please Login First',
                'alert-type' => 'success'
            );

            return redirect()->route('login')->with($notification);
        }
    }
    //End Method 

    

}


