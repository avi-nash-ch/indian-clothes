<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // public function dashboard()
    // {
    //     $users = Customer::count();

    //     $currentMonthSales = Order::where('status', 3)
    //     ->whereMonth('created_at', now()->month)
    //     ->whereYear('created_at', now()->year)
    //     ->sum('total_amount');

    //     $pendingOrders = Order::where('status', 0)->count();
    //     $inprogressOrders = Order::where('status', 1)->count();
    //     $dispatchedOrders = Order::where('status', 2)->count();
    //     $cancelOrders = Order::where('status', 4)->count();
    //     $CODorders = Order::where('payment_type', 0)->count();
    //     $prepaidorders = Order::where('payment_type', 1)->count();
    //     $refundOrders = Order::where('status', 4)->where('refund_reason', '!=', null)->sum('total_amount');

    //     $currentYearSales = Order::where('status', 3)
    //     ->whereYear('created_at', now()->year)
    //     ->sum('total_amount');

    //     return view('admin.dashboard', compact(['users', 'currentMonthSales', 'pendingOrders', 'inprogressOrders', 'dispatchedOrders', 'cancelOrders', 'currentYearSales', 'refundOrders','CODorders','prepaidorders']));
    // }

    public function dashboard()
    {
        $users = Customer::count();

        // Sum of total_amount for COD orders created today
        $todayCODSales = Order::where('status', 3)
            ->where('payment_type', 0)  // 0 for COD orders
            ->whereDate('created_at', now())
            ->sum(DB::raw('total_amount + delivery_charge'));
            
        // Sum of total_amount for prepaid orders created today
        $todayPrepaidSales = Order::where('status', 3)
            ->where('payment_type', 1)  // 1 for prepaid orders
            ->whereDate('created_at', now())
            ->sum('total_amount');


        $currentMonthSales = Order::where('status', 3)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $pendingOrders = Order::where('status', 0)->count();
        $inprogressOrders = Order::where('status', 1)->count();
        $dispatchedOrders = Order::where('status', 2)->count();
        $cancelOrders = Order::where('status', 4)->count();
        $CODorders = Order::where('payment_type', 0)->count();
        $prepaidorders = Order::where('payment_type', 1)->count();
        $refundOrders = Order::where('status', 4)
            ->where('refund_reason', '!=', null)
            ->sum('total_amount');

        $currentYearSales = Order::where('status', 3)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $todayOrderDelivered = Order::where('status', 3)->whereDate('updated_at', Carbon::today())->count();
        return view('admin.dashboard', compact([
            'users', 'currentMonthSales', 'pendingOrders', 'inprogressOrders', 
            'dispatchedOrders', 'cancelOrders', 'currentYearSales', 'refundOrders', 
            'CODorders', 'prepaidorders', 'todayCODSales', 'todayPrepaidSales', 'todayOrderDelivered'
        ]));
    }

}