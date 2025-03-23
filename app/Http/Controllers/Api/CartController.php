<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\RemoveCartRequest;
use App\Http\Requests\CustomerIdRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Setting;

class CartController extends Controller
{   
    public function addToCart(AddToCartRequest $request)
    {
        $customer = Customer::withTrashed()->find($request->customer_id);
        if (!$customer || $customer->deleted_at !== null) {
            return response()->json([
                'message' => 'Customer account is not available or has been block by admin.',
                'status' => 400
            ]);
        }
    
        // Check if the product is soft-deleted
        $product = Product::withTrashed()->find($request->product_id);
        if (!$product || $product->deleted_at !== null) {
            return response()->json([
                'message' => 'Product is not available or has been deleted.',
                'status' => 400
            ]);
        }
    
        // $customer = Customer::where(['id' => $request->customer_id])->first();
        // if($customer){
            $productAlreadyExist = Cart::where(['customer_id' => $request->customer_id, 'product_id' => $request->product_id])->first();
            if($productAlreadyExist){
                // $product = Product::where('id', $request->product_id)->first();
                // $product->

                $productAlreadyExist->quantity += 1;
                $productAlreadyExist->save();
                $response = [
                    'customer' => $productAlreadyExist,
                    'message' => 'Successfully!',
                    'status' => 200
                ];
            }else{
                $data = new Cart;
                $data->customer_id = $request->customer_id;
                $data->product_id = $request->product_id;
                $data->quantity = $request->quantity;
                $data->save();

                $response = [
                    'customer' => $data,
                    'message' => 'Successfully!',
                    'status' => 200
                ];
            }
        // }else{
        //     $response = [
        //         'message' => 'Something Went Wrong!',
        //         'status' => 400
        //     ];
        // }

        return response()->json($response);
    }

    public function removeCart(RemoveCartRequest $request)
    {
        // $customer = Customer::where(['id' => $request->customer_id])->first();
        // if($customer){
            $cart = Cart::where(['customer_id' => $request->customer_id, 'product_id' => $request->product_id])->first();
            if($cart){
                $cart->forceDelete();
                $response = [
                    'message' => 'Successfully removed from cart!',
                    'status' => 200
                ];

            }else{

                $response = [
                    'message' => 'Product not found!',
                    'status' => 200
                ];
            }
        // }else{
        //     $response = [
        //         'message' => 'Something Went Wrong!',
        //         'status' => 400
        //     ];
        // }

        return response()->json($response);
    }

    public function cartMinus(RemoveCartRequest $request)
    {
        // $customer = Customer::where(['id' => $request->customer_id])->first();
        // if($customer){
            $cart = Cart::where(['customer_id' => $request->customer_id, 'product_id' => $request->product_id])->first();
            if($cart){
                if($cart->quantity == 1){
                    $cart->forceDelete();
                    $response = [
                        'message' => 'Successfully Remove from cart!',
                        'status' => 200
                    ];
                }else{
                    $cart->quantity -= 1;
                    $cart->save();

                    $response = [
                        'cart' => $cart,
                        'message' => 'Successfully!',
                        'status' => 200
                    ];
                }
            }else{
                $response = [
                    'message' => 'Product not found!',
                    'status' => 400
                ];
            }
        // }else{
        //     $response = [
        //         'message' => 'Something Went Wrong!',
        //         'status' => 400
        //     ];
        // }

        return response()->json($response);
    }

    public function cart(CustomerIdRequest $request)
    {
        $customer = Customer::where(['id' => $request->customer_id])->whereNull('deleted_at')->first();
        if($customer){

            $setting = Setting::first();
            $cartItems = Cart::leftJoin('products', 'products.id', 'carts.product_id')
                ->leftJoin('units', 'units.id', 'products.unit_id')
                ->where('customer_id', $request->customer_id)
                ->select('products.*', 'carts.quantity', 'units.name as unit', 'carts.quantity as cartQuantity', 'products.quantity as p_qty')
                ->whereNull('products.deleted_at')
                ->get();
                // return $cartItems;

            foreach($cartItems as $cartItem)
            {
                if($cartItem->cartQuantity > $cartItem->p_qty)
                {
                    $cart = Cart::where(['customer_id' => $request->customer_id, 'product_id' => $cartItem->id])->first();
                    $cart->quantity = $cartItem->p_qty;
                    $cart->save();
                    $cartItem->cartQuantity = $cartItem->p_qty;
                }

            }

            $totalPrice = $cartItems->sum(function ($item) {
                return $item->sale_price * $item->cartQuantity;
            });
            $deliveryCharge = '';
            if($totalPrice < $setting->amount){
                $deliveryCharge = $setting->delivery_charge;
            }


            if(count($cartItems)>0){
                $response = [
                    'totalPrice' => $totalPrice,
                    '$deliveryCharge' => $deliveryCharge,
                    'cartItems' => $cartItems,
                    'message' => 'Successfully!',
                    'status' => 200
                ];
            }else{
                $response = [
                    'message' => 'Product not found!',
                    'status' => 400
                ];
            }
        }else{
            $response = [
                'message' => 'Something Went Wrong!',
                'status' => 400
            ];
        }

        return response()->json($response);
    }

    public function cartQuantity(CustomerIdRequest $request)
    {
        $customer = Customer::where('id', $request->customer_id)
            ->whereNull('deleted_at')
            ->first();
    
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
    
        $cartQuantity = Cart::where('customer_id', $request->customer_id)
            ->sum('quantity');
    
        return response()->json(['cart_quantity' => $cartQuantity, 'message' => 'Success', 'code' => 200], 200);
    }
    
}
