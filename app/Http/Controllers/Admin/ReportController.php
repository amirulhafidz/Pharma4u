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
use DateTime;

class ReportController extends Controller
{
    public function AdminAllReports(){
        return view('admin.backend.report.all_report');
    }
    //endd

    public function AdminSearchBydate(Request $request){
        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');
        $orderDate= Order::where('order_date', $formatDate)->latest()
        ->get();

        return view('admin.backend.report.search_bydate',
        compact ('orderDate','formatDate'));
    }
    //endd

    public function AdminSearchBymonth(Request $request){
        $month = $request->month;
        $years = $request->year;
        
        $orderMonth = Order::where('order_month',$month)
        ->where('order_year', $years)
        ->latest()->get();

        return view('admin.backend.report.search_bymonth', 
        compact ('orderMonth','month', 'years'));
    }

    public function AdminSearchByYear(Request $request){
        $years = $request->year;

        $orderYear = Order::where('order_year', $years)
            ->latest()->get();

        return view(
            'admin.backend.report.search_byYear',
            compact('orderYear',  'years')
        );
        
    }
    //endd for admin_report

    public function ClientAllReports()
    {
        return view('client.backend.report.all_report');
    }
    //endd

    public function ClientSearchBydate(Request $request)
    {
        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        $cid = Auth::guard('client')->id();

        $orders = Order::where('order_date', $formatDate)
        ->whereHas('OrderItems', function($query) use ($cid){
            $query->where('client_id',$cid);
        })
        ->latest()
        ->get();

        $orderItemGroupData = OrderItem::with(['order','unit'])
        ->whereIn('order_id',$orders->pluck('id'))
        ->where('client_id',$cid)
        ->orderBy('order_id','desc')
        ->get()
        ->groupBy('order_id');

        return view(
            'client.backend.report.search_bydate',
            compact( 'orderItemGroupData','formatDate')
        );
    }
    //endd

    public function ClientSearchBymonth(Request $request)
    {
        $month = $request->month;
        $years = $request->year;

        $cid = Auth::guard('client')->id();

        $orders = Order::where('order_month', $month)
        ->where('order_year',$years)
            ->whereHas('OrderItems', function ($query) use ($cid) {
                $query->where('client_id', $cid);
            })
            ->latest()
            ->get();

        $orderItemGroupData = OrderItem::with(['order', 'unit'])
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('client_id', $cid)
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');

        return view(
            'client.backend.report.search_bymonth',
            compact('orderItemGroupData', 'month', 'years')
        );
    }

    public function ClientSearchByYear(Request $request)
    {
        $years = $request->year;

        $cid = Auth::guard('client')->id();

        $orders = Order::where('order_year', $years)
            ->whereHas('OrderItems', function ($query) use ($cid) {
                $query->where('client_id', $cid);
            })
            ->latest()
            ->get();

        $orderItemGroupData = OrderItem::with(['order', 'unit'])
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('client_id', $cid)
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');

        return view(
            'client.backend.report.search_byYear',
            compact('orderItemGroupData', 'years')
        );
    }
}
