<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DeliveryBoy\ProfileRequest;
use App\Http\Requests\DeliveryBoy\UpdateProfileRequest;
use App\Http\Requests\DeliveryBoy\OrderUpdateStatusRequest;
use App\Models\DeliveryBoy;
use App\Models\DeliveryboyPaymentStatus;
use App\Models\Order;
use App\Models\OrderMappedProduct;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Otp;
use Illuminate\Support\Facades\DB;

class DeliveryBoyController extends Controller
{
    
    function profile(ProfileRequest $request)
    {
        $deliveryBoy = DeliveryBoy::where(['id' => $request->delivery_boy_id])->first();
        if($deliveryBoy){
            if($deliveryBoy->status != 1){
                $response = [
                    'deliveryBoy' => $deliveryBoy,
                    'message' => 'Successfully!',
                    'status' => 200
                ];
            }else{
                $response = [
                    'message' => 'Account Blocked, please contact to admin!',
                    'status' => 400
                ];
            }
        }else{
            $response = [
                'message' => 'Something went wrong!',
                'status' => 400
            ];
        }
        return response()->json($response);
    }
    function updateProfile(UpdateProfileRequest $request)
    {

        try {
            // Find the delivery boy by ID
            $deliveryBoy = DeliveryBoy::find($request->id);
            // return $deliveryBoy;
            if ($deliveryBoy) {
                // Check if the account is active
                if ($deliveryBoy->status == 1) {
                    return response()->json([
                        'message' => 'Account Blocked, please contact to admin!',
                        'status' => 400
                    ]);
                }
        
                // Handle image upload if present
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('delivery_boy_images', 'public'); // Storing image in 'public' disk
                    $deliveryBoy->image = $imagePath; // Saving the image path to the DB
                }

                
                // Update password if provided and confirm_password matches
                if ($request->filled('simple_password')) {
                    // return $request->filled('simple_password');
                    if ($request->simple_password !== $request->confirm_password) {
                        return response()->json([
                            'message' => 'Password and confirm password do not match!',
                            'status' => 400
                        ]);
                    }
                    
                    $deliveryBoy->simple_password = ($request->simple_password);
                    $deliveryBoy->password = bcrypt($request->password);
                }

                // Save updated profile information
                $deliveryBoy->save();
        
                // Response on successful update
                return response()->json([
                    'deliveryBoy' => $deliveryBoy,
                    'message' => 'Profile updated successfully!',
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Delivery boy not found!',
                    'status' => 404
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred while updating the profile.',
                'error' => $th->getMessage(), // Optionally include the error message for debugging (remove in production)
                'status' => 500
            ]);        }
        
    }
    



    // function pendingOrders(Request $request)
    // {
    //     $deliveryBoy = DeliveryBoy::where(['id' => $request->delivery_boy_id])->first();
    //     if($deliveryBoy){
    //         $orders = Order::join('customers', 'customers.id', 'orders.customer_id')
    //             ->where('delivery_boy_id', $request->delivery_boy_id)
    //             ->whereIn('orders.status', [0,1,2])
    //             ->select('orders.*', 'customers.name as customerName', 'customers.mobile as mobile',
    //             DB::raw("CONCAT('[lat:', lat, ', long:', `long`, ']') as latlong"))
    //             ->get();

    //             // print_r($orders);exit;
                
    //             if(count($orders) > 0){
    //                 foreach($orders as $order){
    //                     $order->products = OrderMappedProduct::where('order_id', $order->id)->leftJoin('products', 'products.id', 'order_mapped_products.product_id')->get();
    //                 }
    //             }


    //         $response = [
    //             'orders' => $orders,
    //             'status' => 200
    //         ];
    //     }else{
    //         $response = [
    //             'message' => 'Something went wrong!',
    //             'status' => 400
    //         ];
    //     }
    //     return response()->json($response);
    // }

    // use Illuminate\Support\Facades\DB;

    public function pendingOrders(Request $request)
    {
        $deliveryBoy = DeliveryBoy::where('id', $request->delivery_boy_id)->first();

        if ($deliveryBoy) {
            $orders = Order::join('customers', 'customers.id', 'orders.customer_id')
                ->where('delivery_boy_id', $request->delivery_boy_id)
                ->whereIn('orders.status', [0, 1, 2])
                ->select(
                    'orders.*', 
                    'customers.name as customerName', 
                    'customers.mobile as mobile',
                    DB::raw("CONCAT('[lat:', lat, ', long:', `long`, ']') as latlong")
                )
                ->get();

            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    // Get all mapped products for each order along with quantity from order_mapped_products
                    $order->products = OrderMappedProduct::where('order_id', $order->id)
                        ->leftJoin('products', 'products.id', 'order_mapped_products.product_id') // Join products
                        ->select(
                            'order_mapped_products.*', 
                            'products.name as productName', 
                            'products.description', 
                            'products.image',
                            'products.expiry_date', 
                            'products.purchase_price', 
                            'products.sale_price',
                            'products.discount_price',
                            'order_mapped_products.quantity'
                        )
                        ->whereNull('products.deleted_at')
                        ->get();
                }
            }

            $response = [
                'orders' => $orders,
                'status' => 200
            ];
        } else {
            $response = [
                'message' => 'Something went wrong!',
                'status' => 400
            ];
        }

        return response()->json($response);
    }


    // function deliveredOrders(Request $request)
    // {
    //     $deliveryBoy = DeliveryBoy::where(['id' => $request->delivery_boy_id])->first();
    //     if($deliveryBoy){
    //         $orders = Order::join('customers', 'customers.id', 'orders.customer_id')
    //             ->where('delivery_boy_id', $request->delivery_boy_id)
    //             ->where('orders.status', 3)
    //             ->select('orders.*', 'customers.name as customerName', 'customers.mobile as mobile')
    //             ->get();

    //             if(count($orders) > 0){
    //                 foreach($orders as $order){
    //                     $order->products = OrderMappedProduct::where('order_id', $order->id)->leftJoin('products', 'products.id', 'order_mapped_products.product_id')->get();
    //                 }
    //             }

    //         $response = [
    //             'orders' => $orders,
    //             'status' => 200
    //         ];
    //     }else{
    //         $response = [
    //             'message' => 'Something went wrong!',
    //             'status' => 400
    //         ];
    //     }
    //     return response()->json($response);
    // }

    public function deliveredOrders(Request $request)
    {
        // Fetch the delivery boy based on ID
        $deliveryBoy = DeliveryBoy::where(['id' => $request->delivery_boy_id])->first();

        // return $deliveryBoy;
        
        if ($deliveryBoy) {
            // Fetch orders with customer details where status = 3 (delivered)
            $orders = Order::join('customers', 'customers.id', 'orders.customer_id')
                ->where('delivery_boy_id', $request->delivery_boy_id)
                ->where('orders.status', 3)
                ->select('orders.*', 'customers.name as customerName', 'customers.mobile as mobile')
                ->get();

            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    // Join the order_mapped_products with products based on product_id
                    $order->products = OrderMappedProduct::where('order_id', $order->id)
                        ->join('products', 'order_mapped_products.product_id', '=', 'products.id')
                        ->select('order_mapped_products.*', 'products.name as productName','products.image')
                        ->whereNull('products.deleted_at')
                        ->get();
                }
            }

            $response = [
                'orders' => $orders,
                'status' => 200
            ];
        } else {
            $response = [
                'message' => 'Something went wrong!',
                'status' => 400
            ];
        }

        return response()->json($response);
    }

   
    public function changeOrderStatus(Request $request)
    {
        // Find the delivery boy
        $deliveryBoy = DeliveryBoy::where('id', $request->delivery_boy_id)->first();
        
        if (!$deliveryBoy) {
            return response()->json([
                'message' => 'Delivery boy not found!',
                'status' => 400
            ]);
        }

        // Find the order
        $order = Order::where('id', $request->order_id)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found!',
                'status' => 400
            ]);
        }

        // Get the customer associated with the order (assuming the Order model has a customer relationship)
        $customer = $order->customer;

        if (!$customer) {
            return response()->json([
                'message' => 'Customer associated with this order not found!',
                'status' => 400
            ]);
        }

        // If status is 3 (delivered), we need to verify the OTP
        if ($request->status == 3) {

            // Check if OTP is provided
            if (!$request->otp_id) {
                return response()->json([
                    'message' => 'OTP ID is required for delivery confirmation!',
                    'status' => 400
                ]);
            }

            // Find the OTP using otp_id and validate if it matches the one sent to the customer's mobile
            $otpRecord = Otp::where('id', $request->otp_id)->where('mobile', $customer->mobile)->first();

            if (!$otpRecord || $otpRecord->otp != $request->otp) {
                return response()->json([
                    'message' => 'Invalid OTP or OTP ID!',
                    'status' => 400
                ]);
            }

            // If OTP is valid, update the delivery boy's wallet and mark the order as delivered
            $deliveryBoy->wallet += $deliveryBoy->delivery_charge;
            $deliveryBoy->save();

            // Update order status to delivered
            $order->status = 3;
            $order->save();

            // Remove the OTP record from the otps table after successful delivery
            $otpRecord->delete();

            // Success response
            return response()->json([
                'message' => 'Order delivered successfully!',
                'status' => 200
            ]);

        } else {
            // If status is not 3, update the order status without OTP validation
            $order->status = $request->status;
            $order->save();

            return response()->json([
                'message' => 'Order status updated successfully!',
                'status' => 200
            ]);
        }
    }

     

    function paymentHistory(Request $request)
    {
        $deliveryBoy = DeliveryBoy::where(['id' => $request->delivery_boy_id])->first();
        if($deliveryBoy){
            $paymentHistories = DeliveryboyPaymentStatus::where('deliveryboy_id', $request->delivery_boy_id)->latest()->get();
            if(count($paymentHistories) > 0){
                $response = [
                    'data' => $paymentHistories,
                    'status' => 200
                ];
            }else{
                $response = [
                    'message' => 'data not found!',
                    'status' => 400
                ];
            }
        }else{
            $response = [
                'message' => 'Something went wrong!',
                'status' => 400
            ];
        }
        return response()->json($response);

    }

    function setting(Request $request)
    {
        $setting = Setting::first();
        if($setting){

            $response = [
                'data' => $setting,
                'status' => 200
            ];
        } else{
            $response = [
                'message' => 'Something went wrong!',
                'status' => 400
            ];
        }
        return response()->json($response);
    }

}