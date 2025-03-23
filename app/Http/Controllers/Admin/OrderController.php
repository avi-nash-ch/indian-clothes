<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Traits\PushNotification;


class OrderController extends Controller
{
    use PushNotification; 
    // public function index(Request $request)
    // {
    //     $status = '';
    //     $orders = Order::leftJoin('customers', 'customers.id', 'orders.customer_id');

    //     // If filters are applied, build the query
    //     if ($request->status != '' || $request->from_date != '' || $request->to_date != '' || $request->payment_status != '') {

    //         // Status filter
    //         if ($request->status != '') {
    //             if ($request->status == 5) {
    //                 $orders->where('orders.status', 4)->where('refund_reason', '!=', null);
    //             } else {
    //                 $orders->where('orders.status', $request->status);
    //             }
    //             $status = $request->status;
    //         }

    //         // Payment status filter
    //         if ($request->payment_status != '') {
    //             $orders->where('orders.payment_type', $request->payment_status);
    //         }

    //         // Date range filter
    //         $today = date('Y-m-d');
    //         $fromDate = $request->input('from_date');
    //         $toDate = $request->input('to_date');

    //         // Ensure the end date is not in the future
    //         if ($toDate && $toDate > $today) {
    //             $toDate = $today;
    //         }

    //         // If a from_date is specified, filter from that date
    //         if ($fromDate) {
    //             $orders->whereDate('orders.created_at', '>=', $fromDate);
    //         }

    //         // If a to_date is specified, filter to that date
    //         if ($toDate) {
    //             $orders->whereDate('orders.created_at', '<=', $toDate);
    //         }
    //     }

    //     // Retrieve the orders based on the above filters
    //     $orders = $orders->select('orders.*', 'customers.name', 'customers.mobile')
    //                     ->latest();
    //                     ->paginate(1000); // Pagination for performance

    //     // Retrieve delivery boys for the dropdown
    //     $deliveryboys = DeliveryBoy::orderBy('name')->get(); // Retrieve delivery boys

    //     return view('admin.order.index', compact('orders', 'status', 'deliveryboys'));
    // }

    public function index(Request $request)
    {
        $status = '';
        // Initialize the orders query with a left join
        $orders = Order::leftJoin('customers', 'customers.id', 'orders.customer_id');

        // If filters are applied, build the query
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

        // Retrieve the orders based on the above filters or all orders if no filters applied
        $orders = $orders->select('orders.*', 'customers.name', 'customers.mobile')
                        ->latest()
                        ->get(); // Pagination for performance

        // Retrieve delivery boys for the dropdown
        $deliveryboys = DeliveryBoy::orderBy('name')->get(); // Retrieve delivery boys

        return view('admin.order.index', compact('orders', 'status', 'deliveryboys'));
    }

    public function view($id)
    {
        $id = decrypt($id);
        $products = Order::join('order_mapped_products', 'order_mapped_products.order_id', 'orders.id')
            ->where('orders.id', $id)
            ->select('order_mapped_products.*', 'orders.delivery_charge', 'orders.id as orderId')
            ->get();

        return view('admin.order.view', compact(['products']));
    }

    public function print($id)
    {
        $setting = Setting::first();

        $id = decrypt($id);
        $products = Order::join('order_mapped_products', 'order_mapped_products.order_id', 'orders.id')
            ->join('customers', 'customers.id', 'orders.customer_id')
            ->where('orders.id', $id)
            ->select('order_mapped_products.*', 'orders.delivery_charge', 'orders.house_address', 'orders.street_address', 'orders.locality', 'orders.landmark', 'orders.pincode', 'orders.total_amount', 'orders.coupon_discount', 'customers.mobile','customers.name', 'orders.payment_type')
            ->get();

        // return $products;

        return view('admin.order.print', compact(['products', 'setting']));
    }

    public function updateOrderStatus(Request $request)
    {
        $order = Order::where('id', $request->orderId)->first();
        if($order){
            $order->status = $request->status;
            $order->save();
            return true;
        }else{
            return false;
        }
    }


    // public function updateDeliveryBoy(Request $request)
    // {
    //     $delivery_boy_id = $request->delivery_boy_id;
    //     $order = Order::where('id', $request->orderId)->first();
    //     if($order){
    //         $order->delivery_boy_id = $delivery_boy_id;
    //         $order->save();
    //         $deliveryBoy = DeliveryBoy::where('id', $delivery_boy_id)->first();
    //         if($deliveryBoy){

    //             $fcm = $deliveryBoy->fcm;
                
    //              push_notification_android($fcm, 'Test');
    
    //             return true;
    //         }
    //     }else{
    //         return false;
    //     }
    // }

    // public function updateDeliveryBoy(Request $request)
    // {
    //     $delivery_boy_id = $request->delivery_boy_id;
    //     $order = Order::where('id', $request->orderId)->first();

    //     if ($order) {
    //         $order->delivery_boy_id = $delivery_boy_id;
    //         $order->save();

    //         $deliveryBoy = DeliveryBoy::where('id', $delivery_boy_id)->first();
    //         if ($deliveryBoy) {
    //             $fcm_token = $deliveryBoy->fcm;
                

    //             // Prepare the request payload for the notification
    //             $notificationRequest = [
    //                 'title' => 'New Order Assigned',
    //                 'body' => 'You have been assigned a new order.',
    //                 'android' => 
    //                     channelId: 'deliveryNotification1',
    //                     importance: 'high',
    //                     sound: 'deliverynotification',
    //             ];

    //             // Call the send_notification method from the PushNotification trait
    //             $this->send_notification($notificationRequest, $fcm_token, 1);

    //             return response()->json(['message' => 'Delivery boy updated and notification sent'], 200);
    //         }
    //     } else {
    //         return response()->json(['error' => 'Order not found'], 404);
    //     }
    // }

    public function updateDeliveryBoy(Request $request)
    {
        $delivery_boy_id = $request->delivery_boy_id;
        $order = Order::where('id', $request->orderId)->first();
    
        if ($order) {
            // Update delivery boy for the order
            $order->delivery_boy_id = $delivery_boy_id;
            if ($order->save()) {
                // Fetch the delivery boy's details
                $deliveryBoy = DeliveryBoy::where('id', $delivery_boy_id)->first();
                if ($deliveryBoy) {
                    $fcm_token = $deliveryBoy->fcm;
    
                    if ($fcm_token) {
                        // Ensure the title and body fields exist in the notification payload
                        $notificationRequest = [
                            'title' => 'New Order Assigned',
                            'body' => 'You have been assigned a new order.',
                            'android' => [
                                'channelId' => 'deliveryNotification1',
                                'importance' => 'high',
                                'sound' => 'deliverynotification',
                            ],
                        ];
    
                        // Call the send_notification method from the PushNotification trait
                        $this->send_notification($notificationRequest, $fcm_token, 1);
    
                        return response()->json(['message' => 'Delivery boy updated and notification sent'], 200);
                    } else {
                        return response()->json(['error' => 'FCM token not available for delivery boy'], 400);
                    }
                } else {
                    return response()->json(['error' => 'Delivery boy not found'], 404);
                }
            } else {
                return response()->json(['error' => 'Failed to update the order'], 500);
            }
        } else {
            return response()->json(['error' => 'Order not found'], 404);
        }
    }
    
    public function delete($id)
    {
        $id = decrypt($id);
        Order::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Order has been deleted successfully.');
    }

    public function refund(Request $request)
    {
        $order = Order::where('id', $request->orderId)->first();
        if($order){
            $order->refund_reason = $request->reason;
            $order->status = 4;
            $order->save();
            return true;
        }else{
            return false;
        }
    }

    public function storeComment(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'required|integer',  // Validate plain order ID
            'comment' => 'required|string|max:1000',  // Validate the comment
        ]);

        // Find the order by the plain ID
        $order = Order::find($request->order_id);

        if ($order) {
            $order->comment = $request->comment; // Update the comment field
            $order->save(); // Save the order
            
            return response()->json(['success' => true, 'message' => 'Comment added successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Order not found']);
        }
    }

}