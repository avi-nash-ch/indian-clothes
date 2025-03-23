<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryBoy;
use App\Models\Order;
use App\Models\Setting;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $status = '';
        $orders = Order::leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
                    ->select('orders.*', 'customers.name', 'customers.mobile');

        // If no filters are applied, display all orders
        if ($request->status != '' || $request->from_date != '' || $request->to_date != '' || $request->payment_status != '') {

            // Status filter
            if ($request->status != '') {
                if ($request->status == 5) {
                    $orders->where('orders.status', 4)->where('refund_reason', '!=', null);
                } else {
                    $orders->where('orders.status', $request->status);
                }
                $status = $request->status;
            }

            // Payment status filter
            if ($request->payment_status != '') {
                $orders->where('orders.payment_type', $request->payment_status);
            }

            // Date range filter
            $today = date('Y-m-d');
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');

            // Ensure the end date is not in the future
            if ($toDate && $toDate > $today) {
                $toDate = $today;
            }

            // If a from_date is specified, filter from that date
            if ($fromDate) {
                $orders->whereDate('orders.created_at', '>=', $fromDate);
            }

            // If a to_date is specified, filter to that date
            if ($toDate) {
                $orders->whereDate('orders.created_at', '<=', $toDate);
            }
        }

        // Retrieve the orders based on the above filters
        $orders = $orders->latest()->get();

        // Retrieve delivery boys for the dropdown
        $deliveryboys = DeliveryBoy::orderBy('name')->get(); // Refined query

        return view('admin.order_report.index', compact('orders', 'status', 'deliveryboys'));
    }

}