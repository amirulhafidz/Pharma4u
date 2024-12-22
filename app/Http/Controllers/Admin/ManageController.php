<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Client;
use App\Models\Unit;
use App\Models\Category;
use App\Models\City;
use App\Models\Gallery;
use App\Models\Banner;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;

class ManageController extends Controller
{
    //Unit METHOD
    public function AdminAllUnit()
    {
        $unit = Unit::orderBy('id', 'desc')->get();
        return view('admin.backend.unit.all_unit', compact('unit'));
    }

    public function AdminAddUnit()
    {
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $client = Client::latest()->get();
        $product = Product::latest()->get();
        return view('admin.backend.unit.add_unit', compact('category', 'city', 'product', 'client'));
    }

    public function AdminStoreUnit(Request $request)
    {

        $ucode = IdGenerator::generate(['table' => 'units', 'field' => 'code', 'length' => 5, 'prefix' => 'UC']);



        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' .
                $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/unit/' .
                $name_gen));
            $save_url = 'upload/unit/' . $name_gen;

            Unit::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace('', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'product_id' => $request->product_id,
                'code' => $ucode,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'client_id' => $request->client_id,
                'most_popular' => $request->most_popular,
                'status' => 1,
                'created_at' => Carbon::now(),
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Unit Inserted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.all.unit')->with($notification);

    }

    public function AdminEditUnit($id)
    {
        $client = Client::latest()->get();
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $unit = Unit::find($id);
        $product = Product::latest()->get();
        return view('admin.backend.unit.edit_unit', compact('category', 'city', 'product', 'unit','client'));
    }

    public function AdminUpdateUnit(Request $request)
    {
        $u_id = $request->id;


        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' .
                $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/unit/' .
                $name_gen));
            $save_url = 'upload/unit/' . $name_gen;

            Unit::find($u_id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace('', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'client_id' => $request->client_id,
                'most_popular' => $request->most_popular,
                'created_at' => Carbon::now(),
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Unit Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.all.unit')->with($notification);

        } else {

            Unit::find($u_id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace('', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'product_id' => $request->product_id,
                'client_id' => $request->client_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_popular' => $request->most_popular,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Unit Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.all.unit')->with($notification);

        }



    }

    public function AdminDeleteUnit($id)
    {
        $item = Unit::find($id);
        $img = $item->image;
        unlink($img);


        Unit::find($id)->delete();

        $notification = array(
            'message' => 'Unit Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }


    ///////////pending pharmacy

    public function PendingPharmacy(){
        $client = Client::where('status', 0)->get();
        return view('admin.backend.pharmacy.pending_pharmacy', compact ('client'));
    }

    public function ClientChangeStatus(Request $request)
    {
        $client = Client::find($request->client_id);
        $client->status = $request->status;
        $client->save();
        return response()->json(['success' => 'Status Change Succesfully']);
    }

    public function ApprovePharmacy()
    {
        $client = Client::where('status', 1)->get();
        return view('admin.backend.pharmacy.approve_pharmacy', compact('client'));
    }
    //end method


    //banner method

    public function AllBanner(){
        $banner = Banner::latest()->get();
        return view('admin.backend.banner.all_banner', compact('banner'));
    }//end method

    public function BannerStore(Request $request)
    {

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' .
                $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' .
                $name_gen));
            $save_url = 'upload/banner/' . $name_gen;

            Banner::create([
                'url' => $request->url,
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Banner Inserted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    
    public function EditBanner($id){
        $banner = Banner::find($id);
        if ($banner){
            $banner->image = asset($banner->image);
        }
        return response()->json($banner);


    }

    public function BannerUpdate(Request $request)
    {

        $banner_id = $request->banner_id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' .
                $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' .
                $name_gen));
            $save_url = 'upload/banner/' . $name_gen;

            Banner::find($banner_id)->update([
                'url' => $request->url,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Banner Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.banner')->with($notification);

        } else {

            Banner::find($banner_id)->update([
                'url' => $request->url,
            ]);
            $notification = array(
                'message' => 'Banner Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.banner')->with($notification);

        }


    }

    public function DeleteBanner($id)
    {
        $item = Banner::find($id);
        $img = $item->image;
        unlink($img);


        Banner::find($id)->delete();

        $notification = array(
            'message' => 'Banner Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
}
