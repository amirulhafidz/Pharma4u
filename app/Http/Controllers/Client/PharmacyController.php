<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Models\City;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
Use Carbon\Carbon;

class PharmacyController extends Controller
{
    public function AllProduct()
    {
        $id = Auth::guard('client')->id();
        $product = Product::where('client_id',$id)->orderBy('id','desc')->get();
        //$product = Product::latest()->get();
        return view('client.backend.product.all_product', compact('product'));
    }


    public function AddProduct(){
        
        return view('client.backend.product.add_product');

    }

    public function StoreProduct(Request $request)
    {

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' .
                $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' .
                $name_gen));
            $save_url = 'upload/product/' . $name_gen;

            Product::create([
                'product_name' => $request->product_name,
                'client_id' => Auth::guard('client')->id(),
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Product Inserted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.product')->with($notification);

    }
    // End Method 


    public function EditProduct($id)
    {
        $product = Product::find($id);
        return view('client.backend.product.edit_product', compact
        ('product'));
    }

    public function UpdateProduct(Request $request)
    {


        $product_id = $request->id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' .
                $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' .
                $name_gen));
            $save_url = 'upload/product/' . $name_gen;

            Product::find($product_id)->update([
                'product_name' => $request->product_name,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Product Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.product')->with($notification);

        } else{

            Product::find($product_id)->update([
                'product_name' => $request->product_name,

            ]);
            $notification = array(
                'message' => 'Product Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.product')->with($notification);


        }

       
    }


    public function DeleteProduct($id)
    {
        $item = Product::find($id);
        $img = $item->image;
        unlink($img);


        Product::find($id)->delete();

        $notification = array(
            'message' => 'Product Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
//End Method


//Unit METHOD
    public function AllUnit()
    {
        $id = Auth::guard('client')->id();
        $category = Category::latest()->get();
        $unit = Unit::where('client_id',$id)->orderBy('id','desc')->get();
        return view('client.backend.unit.all_unit', compact('unit'));
    }

    public function AddUnit()
    {
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $id = Auth::guard('client')->id();
        $product = Product::where('client_id', $id)->latest()->get();
        //$product = Product::latest()->get();
        return view('client.backend.unit.add_unit', compact('category','city','product'));
    }

    public function StoreUnit(Request $request)
    {

    $ucode = IdGenerator::generate(['table' => 'units','field'=>'code','length' => 5, 'prefix' => 'UC']);

    

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
                'slug' => strtolower(str_replace('','-',$request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'product_id' => $request->product_id,
                'code' => $ucode,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'client_id' => Auth::guard('client')->id(),
                'description' => $request->description,
                'most_popular' => $request->most_popular,
                'status' =>1,
                'created_at'=>Carbon::now(),
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Unit Inserted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.unit')->with($notification);

    }

    public function EditUnit($id)
    {
        $cid = Auth::guard('client')->id();
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $unit = Unit::find($id);
        $product = Product::where('client_id', $cid)->latest()->get();
        // $product = Product::latest()->get();
        return view('client.backend.unit.edit_unit', compact('category','city','product','unit'));
    }

    public function UpdateUnit(Request $request)
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
                'description' => $request->description,
                'most_popular' => $request->most_popular,
                'created_at' => Carbon::now(),
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Unit Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.unit')->with($notification);

        }else{

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
                'description' => $request->description,
                'most_popular' => $request->most_popular,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Unit Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.unit')->with($notification);

        }

        

    }

    public function DeleteUnit($id)
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
    //End unit method

public function ChangeStatus(Request $request){
    $unit = Unit::find($request-> unit_id);
    $unit->status = $request->status;
    $unit->save();
    return response()->json(['success' => 'Status Change Succesfully']);
}

//End Method
/// START GALLERY
    public function AllGallery()
    {
        $cid = Auth::guard('client')->id();
        $gallery = Gallery::where('client_id',$cid)->latest()->get();
        return view('client.backend.gallery.all_gallery', compact('gallery'));
    }

    public function AddGallery()
    {
        return view('client.backend.gallery.add_gallery');
    }

public function StoreGallery(Request $request){

    $images=$request->file('gallery_img');
    foreach ($images as $gimg){
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' .
            $gimg->getClientOriginalExtension();
            $img = $manager->read($gimg);
            $img->resize(800, 800)->save(public_path('upload/gallery/' .
            $name_gen));
            $save_url = 'upload/gallery/' . $name_gen;

            Gallery::insert([
                'client_id' => Auth::guard('client')->id(),
                'gallery_img' => $save_url,
            ]);

        }//endforeach

        $notification = array(
            'message' => 'Gallery Inserted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.gallery')->with($notification);

    }//endmethodd

    public function EditGallery($id){
        $gallery = Gallery::find($id);
        return view('client.backend.gallery.edit_gallery', compact('gallery'));


    }


    public function UpdateGallery(Request $request)
    {
        $gallery_id = $request->id;


        if ($request->hasFile('gallery_img')) {
            $image = $request->file('gallery_img');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' .
                $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(800, 800)->save(public_path('upload/gallery/' .
                $name_gen));
            $save_url = 'upload/gallery/' . $name_gen;

            $gallery= Gallery::find($gallery_id);
            if ($gallery->gallery_img){
                $img =  $gallery->gallery_img;
                unlink($img);
            }

            $gallery->update([
                'gallery_img'=> $save_url,
            ]);


            $notification = array(
                'message' => 'Gallery Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.gallery')->with($notification);

        } else {

                $notification = array(
                'message' => 'No image selected',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
;

        }



    }

    public function DeleteGallery($id)
    {


        $item = Gallery::find($id);
        $img = $item->gallery_img;
        unlink($img);


        Gallery::find($id)->delete();

        $notification = array(
            'message' => 'Gallery Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }



}