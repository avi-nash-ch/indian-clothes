<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\CouponCode;
use App\Models\OrderMappedProduct;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\CustomerIdRequest;
use App\Http\Requests\IdRequest;
use App\Http\Requests\ApplyCouponCodeRequest;
use App\Http\Requests\OtpRequest;
use App\Models\Otp;
use App\Models\Response;
use App\Http\Requests\VerifyOtpRequest;
use PDF;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
   
    public function order(OrderRequest $request)
    {
        $customer = Customer::find($request->customer_id);
    
        if ($customer->status == 1) {
            return response()->json([
                'message' => 'Customer is blocked!',
                'status' => 401
            ]);
        }

        $address = Address::where([
            ['id', $request->address_id],
            ['customer_id', $request->customer_id]
        ])->first();

        $setting = Setting::first();
        $carts = Cart::where('customer_id', $request->customer_id)->get();
    
        if ($carts->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty!',
                'status' => 400
            ]);
        }
    
        // Create new order
        $order = new Order();
        $order->customer_id = $request->customer_id;
        $order->payment_type = $request->payment_type;
        $order->coupon_code = $request->coupon_code;
        $order->house_address = $address->house_address;
        $order->street_address = $address->street_address;
        $order->locality = $address->locality;
        $order->landmark = $address->landmark;
        $order->pincode = $address->pincode;
        $order->lat = $address->lat;
        $order->long = $address->long;
        $order->save();
        $razor_pay_id=0;
        $total_amount = 0;
    
        foreach ($carts as $cart) {
            $product = Product::find($cart->product_id);
    
            if (!$product) {
                continue;
            }
    
            if ($product->quantity >= $cart->quantity) {
                $orderMappedProduct = new OrderMappedProduct();
                $orderMappedProduct->customer_id = $request->customer_id;
                $orderMappedProduct->order_id = $order->id;
                $orderMappedProduct->product_id = $product->id;
                $orderMappedProduct->product_name = $product->name;
                $orderMappedProduct->mrp = $product->discount_price;
                $orderMappedProduct->price = $product->sale_price;
                $orderMappedProduct->quantity = $cart->quantity;
                $orderMappedProduct->amount = $product->sale_price * $cart->quantity;
                $orderMappedProduct->save();
    
                $total_amount += $product->sale_price * $cart->quantity;
                $product->quantity -= $cart->quantity;
                $product->save();
    
                Cart::where(['customer_id' => $request->customer_id, 'product_id' => $product->id])->forceDelete();
            } else {
                return response()->json([
                    'message' => 'Insufficient stock for product: ' . $product->name,
                    'status' => 400
                ]);
            }
        }
    
        if ($total_amount < $setting->amount) {
            $order->delivery_charge = $setting->delivery_charge;
        } else {
            $order->delivery_charge = 0;
        }
           
        $order->total_amount = $total_amount;
        $final_amount = $order->total_amount + $order->delivery_charge;
        if($order->payment_type == 1){
            // $final_amount = $order->total_amount + $order->delivery_charge;
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            // Create order in Razorpay
            $razorpay_order = $api->order->create([
                'receipt' => 'gharbazar_'.$order->id, // Unique receipt ID
                'amount' => $final_amount * 100, // Amount in paise
                'currency' => 'INR',
                'payment_capture' => 1, // Auto capture payment
            ]);
            $razor_pay_id=$razorpay_order['id'];
        }
        $order->razor_pay_id=$razor_pay_id ?? null;
        $order->save();

        $response = [
            'message' => 'Your order placed successfully!',
            'status' => 200,
            'order_id' => $order->id, // Add order_id to response
            'razor_pay_id' =>$razor_pay_id ?? null,
            'final_amount' =>$final_amount,
        ];

    
        // Generate invoice for the order
        $this->orderInvoice($order->id);

        // Send email after order is successfully placed
        Mail::send('emails.order_placed', [
            'order' => $order,
            'customer' => $customer,
            'products' => $order->mappedProducts 
        ], function ($message) use ($customer) {
            $message->to('orders@gharkabazaar.in')
                    ->subject('New Order Placed');
        });
    
        return response()->json($response);
    }

    // public function order(OrderRequest $request)
    // {
    //     $customer = Customer::find($request->customer_id);

    //     // if (!$customer) {
    //     //     return response()->json([
    //     //         'message' => 'Customer not found!',
    //     //         'status' => 400
    //     //     ]);
    //     // }
    
    //     if ($customer->status == 1) {
    //         return response()->json([
    //             'message' => 'Customer is blocked!',
    //             'status' => 401
    //         ]);
    //     }

    //     $address = Address::where([
    //         ['id', $request->address_id],
    //         ['customer_id', $request->customer_id]
    //     ])->first();
    
    //     // if (!$address) {
    //     //     return response()->json([
    //     //         'message' => 'Invalid address for this customer!',
    //     //         'status' => 400
    //     //     ]);
    //     // }
    

    //     $setting = Setting::first();
    //     $carts = Cart::where('customer_id', $request->customer_id)->get();
    
    //     if ($carts->isEmpty()) {
    //         return response()->json([
    //             'message' => 'Your cart is empty!',
    //             'status' => 400
    //         ]);
    //     }
    
    //     // Create new order
    //     $order = new Order();
    //     $order->customer_id = $request->customer_id;
    //     $order->payment_type = $request->payment_type;
    //     $order->coupon_code = $request->coupon_code;
    //     $order->house_address = $address->house_address;
    //     $order->street_address = $address->street_address;
    //     $order->locality = $address->locality;
    //     $order->landmark = $address->landmark;
    //     $order->pincode = $address->pincode;
    //     $order->lat = $address->lat;
    //     $order->long = $address->long;
    //     $order->save();
    //     $razor_pay_id=0;
    //     $total_amount = 0;
    
    //     foreach ($carts as $cart) {
    //         $product = Product::find($cart->product_id);
    
    //         if (!$product) {
    //             continue; // Skip if product not found
    //         }
    
    //         if ($product->quantity >= $cart->quantity) {
    //             $orderMappedProduct = new OrderMappedProduct();
    //             $orderMappedProduct->customer_id = $request->customer_id;
    //             $orderMappedProduct->order_id = $order->id;
    //             $orderMappedProduct->product_id = $product->id;
    //             $orderMappedProduct->product_name = $product->name;
    //             $orderMappedProduct->mrp = $product->discount_price;
    //             $orderMappedProduct->price = $product->sale_price;
    //             $orderMappedProduct->quantity = $cart->quantity;
    //             $orderMappedProduct->amount = $product->sale_price * $cart->quantity;
    //             $orderMappedProduct->save();
    
    //             $total_amount += $product->sale_price * $cart->quantity;
    //             $product->quantity -= $cart->quantity;
    //             $product->save();
    
    //             Cart::where(['customer_id' => $request->customer_id, 'product_id' => $product->id])->forceDelete();
    //         } else {
    //             return response()->json([
    //                 'message' => 'Insufficient stock for product: ' . $product->name,
    //                 'status' => 400
    //             ]);
    //         }
    //     }
    
    //     if ($total_amount < $setting->amount) {
    //         $order->delivery_charge = $setting->delivery_charge;
    //     } else {
    //         $order->delivery_charge = 0;
    //     }
    
    //     // Apply coupon if provided
    //     if ($request->filled('coupon_code')) {
    //         $couponCode = CouponCode::where('coupon_code', $request->coupon_code)->first();

    //         if ($couponCode) {
    //             $currentDate = now();
    //             // Check if the coupon is active between start_date and end_date
    //             if ($currentDate < $couponCode->start_date || $currentDate > $couponCode->end_date) {
    //                 return response()->json([
    //                     'message' => 'This coupon is not active. Please check the validity period.',
    //                     'status' => 400
    //                 ]);
    //             }

    //             // Check if maximum user usage has been reached
    //             $usedCount = Order::where('coupon_code', $request->coupon_code)->count();
    //             if ($usedCount >= $couponCode->maximum_user) {
    //                 return response()->json([
    //                     'message' => 'This coupon has reached its maximum usage limit.',
    //                     'status' => 400
    //                 ]);
    //             }

    //             if ($total_amount < $couponCode->minimum_amount) {
    //                 return response()->json([
    //                     'message' => 'This coupon requires a minimum order amount of Rs. '. $couponCode->minimum_amount,
    //                     'status' => 400
    //                 ]);
    //             }

    //             // Calculate the discount
    //             $discountAmount = ($couponCode->offer / 100) * $total_amount;

    //             $order->total_amount = $total_amount - $discountAmount;                
    //             $order->coupon_discount = $discountAmount;
    //             $final_amount = $order->total_amount + $order->delivery_charge;

    //             if($order->payment_type == 1){
    //                 // $final_amount = $order->total_amount + $order->delivery_charge;

    //                 $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    //                 // Create order in Razorpay
    //                 $razorpay_order = $api->order->create([
    //                     'receipt' => 'gharbazar_'.$order->id, // Unique receipt ID
    //                     'amount' => $final_amount * 100, // Amount in paise
    //                     'currency' => 'INR',
    //                     'payment_capture' => 1, // Auto capture payment
    //                 ]);
                    
    //                 $razor_pay_id = $razorpay_order['id'];
    //             }
    //             $order->razor_pay_id=$razor_pay_id ?? null;
    //             $order->save();
    //             $response = [
    //                 'message' => 'Order Id Created Successfully with coupon applied!',
    //                 'status' => 200,
    //                 'order_id' => $order->id,
    //                 'razor_pay_id' =>$razor_pay_id ?? null,
    //                 'final_amount' => $final_amount,
    //             ];
    //         } else {
    //             $response = [
    //                 'message' => 'Invalid Coupon Code!',
    //                 'status' => 400
    //             ];
    //         }
    //     } else {
    //     // exit();
    //         $order->total_amount = $total_amount;
    //         $final_amount = $order->total_amount + $order->delivery_charge;

    //         if($order->payment_type == 1){
    //             // $final_amount = $order->total_amount + $order->delivery_charge;
    //             $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    //             // Create order in Razorpay
    //             $razorpay_order = $api->order->create([
    //                 'receipt' => 'gharbazar_'.$order->id, // Unique receipt ID
    //                 'amount' => $final_amount * 100, // Amount in paise
    //                 'currency' => 'INR',
    //                 'payment_capture' => 1, // Auto capture payment
    //             ]);
    //             $razor_pay_id=$razorpay_order['id'];
    //         }
    //         $order->razor_pay_id=$razor_pay_id ?? null;
    //         $order->save();

    //         // print_r($razorpay_order['id']);exit();
    //         $response = [
    //             'message' => 'Your order placed successfully!',
    //             'status' => 200,
    //             'order_id' => $order->id, // Add order_id to response
    //             'razor_pay_id' =>$razor_pay_id ?? null,
    //             'final_amount' =>$final_amount,
    //         ];
    //     }

    
    //     // Generate invoice for the order
    //     $this->orderInvoice($order->id);


    //     // Send email after order is successfully placed
    //     Mail::send('emails.order_placed', [
    //         'order' => $order,
    //         'customer' => $customer,
    //         'products' => $order->mappedProducts 
    //     ], function ($message) use ($customer) {
    //         $message->to('orders@gharkabazaar.in')
    //                 ->subject('New Order Placed');
    //     });
    
    //     return response()->json($response);
    // }

    public function verifyOrder(Request $request)
    {
        try {
            // Initialize Razorpay API
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // Verify Razorpay signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];


            $api->utility->verifyPaymentSignature($attributes);

            // Find the transaction in the database
            $order = Order::where('razor_pay_id', $request->razorpay_order_id)->first();

            if ($order) {
                // Update transaction record
                // $transaction->payment_id = $request->razorpay_payment_id;
                // $transaction->signature = $request->razorpay_signature;
                $order->razor_pay_status = 1; // Mark as successful
                $order->save();
            }

            return response()->json([
                'message' => 'Payment successfully done.',
                'success' => true,
                'razor_pay_status' => $order->razor_pay_status,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            // Handle payment failure
            $order = Order::where('razor_pay_id', $request->razorpay_order_id)->first();
            if ($order) {
                $order->razor_pay_status = 2; // Mark as failed
                $order->save();
            }

            return response()->json([
                'message' => 'Payment verification failed: ' . $e->getMessage(),
                'success' => false,
                'razor_pay_status' => $order->razor_pay_status,
                'code' => 400
            ], 400);
        }
    }
    

    public function callback(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);

            // Extract necessary details from Razorpay webhook
            $razorpayOrderId = $data['payload']['payment']['entity']['order_id'] ?? null;

            // Fetch order details from the database
            $order = Order::where('razor_pay_id', $razorpayOrderId)->first();
            if (!$order) {
                Log::error("Order not found for Razorpay Order ID: $razorpayOrderId");
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Fetch total amount & delivery charge
            $totalAmount = $order->total_amount ?? 0;
            $deliveryCharge = $order->delivery_charge ?? 0;
            $finalAmount = $totalAmount + $deliveryCharge;

            // Add final amount to webhook payload
            $data['payload']['payment']['entity']['final_amount'] = $finalAmount;

            // Store or update response to avoid duplicates
            Response::create(
                // ['razorpay_order_id' => $razorpayOrderId], // Unique constraint
                ['full_response' => json_encode($data)]
            );

            return response()->json(['message' => 'Webhook processed successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Webhook Error: ' . $e->getMessage());

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function myOrder(CustomerIdRequest $request)
    {
        $orders = Order::where('customer_id', $request->customer_id)->latest()->get();
        // return $orders;
        if(count($orders)>0){
            $response = [
                'orders' => $orders,
                'status' => 200
            ];
        }else{
            $response = [
                'message' => 'Your cart is empty. Please add some products to continue.!',
                'status' => 400
            ];
        }


        return response()->json($response);
    }

    public function orderByProducts(IdRequest $request)
    {
        $customer = Customer::where(['id' => $request->customer_id])->first();
        if($customer){
            $products = OrderMappedProduct::leftJoin('orders', 'orders.id', 'order_mapped_products.order_id')
                ->join('products', 'products.id', 'order_mapped_products.product_id')
                ->where('orders.id', $request->id)
                ->whereNull('products.deleted_at')
                ->select('order_mapped_products.*', 'products.image', 'products.image1', 'products.image2', 'products.image3', 'products.image4',)
                ->get();

                // return $products;
            if(count($products)>0){
                $response = [
                    'products' => $products,
                    'status' => 200
                ];
            }else{
                $response = [
                    'message' => 'Product Not Found.!',
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

    public function cancelOrder(IdRequest $request)
    {
        $customer = Customer::where(['id' => $request->customer_id])->first();
        if($customer){
            $order = Order::where('id', $request->id)->first();
            if($order){
                $order->status = 4;
                $order->reason = $request->reason;
                $order->save();
                $response = [
                    'message' => 'Successfully!',
                    'status' => 200
                ];
            }else{
                $response = [
                    'message' => 'Something went wrong!',
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

    public function couponCode(CustomerIdRequest $request)
    {
        $customer = Customer::where(['id' => $request->customer_id])->first();
        if($customer){
            $couponCode = CouponCode::whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->latest()
                ->get();
                
            if($couponCode){
                $response = [
                    'data' => $couponCode,
                    'status' => 200
                ];
            }else{
                $response = [
                    'data' => '',
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
    
    // public function applyCouponCode(ApplyCouponCodeRequest $request)
    // {
    //     $customer = Customer::where(['id' => $request->customer_id])->first();
    //     if($customer){

    //         $couponCode = CouponCode::where('coupon_code', $request->coupon_code)->first();

    //         if (!$couponCode) {
    //             $response = [
    //                 'message' => 'Invalid coupon code!',
    //                 'status' => 400
    //             ];
    //         }else{

    //             $totalAmount = $request->total_amount;

    //             $discountAmount = $this->calculateDiscountAmount($couponCode, $totalAmount);

    //             $finalAmount = $totalAmount - $discountAmount;

    //             $response = [
    //                 'message' => 'Successful!',
    //                 'totalAmount' => $totalAmount,
    //                 'discountAmount' => $discountAmount,
    //                 'finalAmount' => $finalAmount,
    //                 'status' => 200
    //             ];
    //         }
    //     }else{
    //         $response = [
    //             'message' => 'Something went wrong!',
    //             'status' => 400
    //         ];
    //     }

    //     return response()->json($response);
    // }

    // protected function calculateDiscountAmount($couponCode, $totalAmount)
    // {
    //     return $couponCode->offer;
    // }
    
    
    public function orderInvoice($order_id)
    {
        // Fetch the order products and customer details using joins
        $products = Order::join('order_mapped_products', 'order_mapped_products.order_id', 'orders.id')
            ->join('customers', 'customers.id', 'orders.customer_id')
            ->where('orders.id', $order_id)
            ->select('order_mapped_products.*', 'orders.delivery_charge', 'orders.house_address', 'orders.street_address', 'orders.locality', 'orders.landmark', 'orders.pincode', 'orders.total_amount', 'orders.coupon_discount', 'customers.mobile','customers.name', 'orders.payment_type')
            ->get();
            // return $products;      

        $setting = Setting::first();    
        
        // Calculate total price of products
        $total = 0;
        foreach ($products as $product) {
            $total += ($product->price * $product->quantity);
        }

        // Load the view to generate the PDF
        $pdf = PDF::loadView('admin.order.print', [
            'setting' => $setting,
            'products' => $products,
            'total' => $total
        ]);

        $filePath = storage_path('app/public/invoices/'); 
        
        if (!file_exists($filePath)) {
            mkdir($filePath, 0777, true);
        }

        $fileName = 'invoice_order_' . $order_id . '.pdf';
        // return $fileName;
        $pdf->save($filePath . $fileName);


        $order = Order::find($order_id);
        $order->invoice_path = 'invoices/' . $fileName;
        $order->save();

        return response()->json([
            'message' => 'Invoice generated and saved successfully!',
            'invoice_path' => asset('storage/invoices/' . $fileName), // Public path for access
            'status' => 200
        ]);
    }

    public function sendOtpDelivery(Request $request)
    {
        // Step 1: Validate the request to ensure 'order_id' is present and exists in the orders table
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',  // Ensure that order_id exists in orders table
        ]);
    
        // Step 2: Fetch the order using the order_id from the request
        $order = Order::find($request->order_id);
    
        // Step 3: Retrieve the customer associated with the order
        $customer = $order->customer; // Assuming there's a relationship between Order and Customer
        $deliveryBoy = $order->deliveryBoy;
    
        // Check if the customer exists
        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found for this order!',
                'status' => 404
            ], 404);
        }
        if (!$deliveryBoy) {
            return response()->json([
                'message' => 'Delivery Boy not found for this order!',
                'status' => 404
            ], 404);
        }
    
        // Step 4: Retrieve the customer's mobile number
        $mobile = $customer->mobile;
    
        // Step 5: Generate a random OTP
        $otp = rand(1000, 9999);
    
        // Step 6: Save the OTP and mobile number in the OTP table
        $data = new Otp();
        $data->mobile = $mobile;
        $data->otp = $otp;
        $data->save();
    
        // Step 7: Send the OTP to the customer's mobile number
        Send_OTP_for_Delivery($mobile, $otp); // Assuming this function handles the SMS sending
    
        // Step 8: Prepare a success response
        return response()->json([
            'message' => 'OTP sent successfully to the customer!',
            'status' => 200,
            'otp_id' => $data->id  // Return the ID of the saved OTP
        ], 200);
    }
}