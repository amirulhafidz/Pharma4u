<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;

class ManageOrderController extends Controller
{
    public function AdminPendingOrder(){
        $allData = Order::where('status', 'Pending')
        ->orderBy('id','desc')->get();
        return view('admin.backend.order.pending_order' ,compact('allData'));
    }//END METHOD

    public function AdminConfirmedOrder()
    {
        $allData = Order::where('status', 'confirm')
            ->orderBy('id', 'desc')->get();
        return view('admin.backend.order.confirmed_order', compact('allData'));
    }//END METHOD

    public function AdminProcessingOrder()
    {
        $allData = Order::where('status', 'processing')
            ->orderBy('id', 'desc')->get();
        return view('admin.backend.order.processing_order', compact('allData'));
    }//END METHOD

    public function AdminDeliveredOrder()
    {
        $allData = Order::where('status', 'delivered')
            ->orderBy('id', 'desc')->get();
        return view('admin.backend.order.delivered_order', compact('allData'));
    }//END METHOD


    public function AdminOrderDetails($id){
        $order =Order::with('user')->where('id',$id)->first();
        $orderItem = OrderItem::with('unit')->where('order_id',$id)
        ->orderBy('id', 'desc')->get();

        $totalPrice = 0;
        foreach($orderItem as $item){
            $totalPrice += $item->price * $item->qty;
        }

        return view('admin.backend.order.admin_order_details', compact
        ('order','orderItem','totalPrice'));
    }//END METHOD


    public function AdminPendingToConfirm($id){
        Order::find($id)->update(['status' => 'confirm']);

        $notification = array(
            'message' => 'Order Confirmed Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.confirmed.order')->with($notification);
    }//END METHOD

    public function AdminConfirmToProcess($id)
    {
        Order::find($id)->update(['status' => 'processing']);

        $notification = array(
            'message' => 'Order Processed Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.processing.order')->with($notification);
    }//END METHOD

    public function AdminProcessToDelivered($id)
    {
        Order::find($id)->update(['status' => 'delivered']);

        $notification = array(
            'message' => 'Order Delivered Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.delivered.order')->with($notification);
    }
    //END METHOD
    public function AllClientOrders()
    {
        $clientId = Auth::guard('client')->id();
        $orderItemGroupData= OrderItem::with(['unit','order'])
        ->where('client_id',$clientId)
        ->orderBy('order_id','desc')
        ->get()
        ->groupBy('order_id');
        return view('client.backend.order.all_orders', compact
        ('orderItemGroupData'));
    }//END METHOD

    public function ClientPendingOrder()
    {
        $clientId = Auth::guard('client')->id();
        $allData = OrderItem::with(['unit','order'])
        ->where('client_id',$clientId)
        ->whereHas('order', function ($query) {
            $query->where('status', 'pending');
            })
        ->orderBy('order_id','desc')
        ->get()
        ->groupBy('order_id');
        return view('client.backend.order.pending_order', compact('allData'));
    }//END METHOD

    public function ClientConfirmedOrder()
    {
        $clientId = Auth::guard('client')->id();
        $allData = OrderItem::with(['unit', 'order'])
            ->where('client_id', $clientId)
            ->whereHas('order', function ($query) {
                $query->where('status', 'confirm');
            })
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');
        return view('client.backend.order.confirm_order', compact('allData'));
    }//END METHOD

    public function ClientProcessingOrder()
    {
        $clientId = Auth::guard('client')->id();
        $allData = OrderItem::with(['unit','order'])
        ->where('client_id',$clientId)
        ->whereHas('order', function ($query) {
            $query->where('status', 'processing');
            })
        ->orderBy('order_id','desc')
        ->get()
        ->groupBy('order_id');
        return view('client.backend.order.processing_order', compact('allData'));
    }//END METHOD

    public function ClientDeliveredOrder()
    {
        $clientId = Auth::guard('client')->id();
        $allData = OrderItem::with(['unit','order'])
        ->where('client_id',$clientId)
        ->whereHas('order', function ($query) {
            $query->where('status', 'delivered');
            })
        ->orderBy('order_id','desc')
        ->get()
        ->groupBy('order_id');
        return view('client.backend.order.delivered_order', compact('allData'));
    }//END METHOD


    public function ClientPendingToConfirm($id)
    {
        Order::find($id)->update(['status' => 'confirm']);

        $notification = array(
            'message' => 'Order Confirmed Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('client.confirmed.order')->with($notification);
    }//END METHOD

    public function ClientConfirmToProcess($id)
    {
        Order::find($id)->update(['status' => 'processing']);

        $notification = array(
            'message' => 'Order Processed Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('client.processing.order')->with($notification);
    }//END METHOD

    public function ClientProcessToDelivered($id)
    {
        Order::find($id)->update(['status' => 'delivered']);

        $notification = array(
            'message' => 'Order Delivered Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('client.delivered.order')->with($notification);
    }
    //END METHOD

    public function ClientOrderDetails($id){
        $cid = Auth::guard('client')->id();
        $order = Order::with('user')->where('id', $id)->first();
        $orderItem = OrderItem::with('unit')->where('order_id', $id)
            ->where('client_id',$cid)
            ->orderBy('id', 'desc')->get();

        $totalPrice = 0;
        foreach ($orderItem as $item) {
            $totalPrice += $item->price * $item->qty;
        }

        return view('client.backend.order.client_order_details', compact
        ('order', 'orderItem', 'totalPrice')); 

    }//END METHOD

    public function UserOrderList(){
        $userId = Auth::user()->id;
        $allUserOrder = Order::where('user_id', $userId)->orderBy(
            'id','desc')->get();
        return view('frontend.dashboard.order.order_list', compact
        ( 'allUserOrder'));

    }
    //END METHOD


    public function UserOrderDetails($id){
        $order = Order::with('user')->where('id', $id)
        ->where('user_id',Auth::id())->first();
        $orderItem = OrderItem::with('unit')->where('order_id', $id)
            ->orderBy('id', 'desc')->get();

        $totalPrice = 0;
        foreach ($orderItem as $item) {
            $totalPrice += $item->price * $item->qty;
        }

            return view('frontend.dashboard.order.order_details', compact
            ('order','orderItem','totalPrice'));

    }

    public function UserInvoiceDownload($id){
        $order = Order::with('user')->where('id', $id)
            ->where('user_id', Auth::id())->first();
        $orderItem = OrderItem::with('unit')->where('order_id', $id)
            ->orderBy('id', 'desc')->get();

        $totalPrice = 0;
        foreach ($orderItem as $item) {
            $totalPrice += $item->price * $item->qty;
        }

        $pdf = Pdf::loadView('frontend.dashboard.order.invoice_download', 
        compact('order','orderItem', 'totalPrice'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('pharma4u_inv.pdf');

        

    }
}







