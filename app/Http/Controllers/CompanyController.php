<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Admin;
use App\Models\UnitMaster;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Challan;
use App\Models\About;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductMapping;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    public function productListing()
    {
        $products = Product::join('categories', 'products.categories', 'categories.id')
        ->join('brands', 'products.brand', 'brands.id')
        ->join('units', 'products.unit_name', 'units.id')
        ->where('products.companyPrice', '!=', null)
        ->select('products.*', 'categories.name as category', 'brands.name as brand', 'units.unit_name as unitName')
        ->get();

        $favourite = Favourite::selectRaw('GROUP_CONCAT(product_id) as product_id')
        ->where('company_id', Auth::id())
        ->first();

        return view ('company.product_listing', compact(['products','favourite']));
    }


    public function addOrder(Request $request )
    {
        // return $request->all();


        $loc=decrypt($request->Location);
        $productId=$request->productId;
        $mappedID=$request->mappedID;
        $product = Product::select('products.*', 'users.role')
            // ->join('product_mappings', 'product_mappings.product_id', '=', 'products.id')
            ->join('users', 'users.id', '=', 'product_mappings.added_by')
            ->where('product_mappings.deleted_at', null)
            ->where('products.deleted_at', null)
            ->where('users.deleted_at', null)
            ->where('products.id', $productId)
            ->first();

        // return $product;

        $order = Order::where('product_id', $productId)
            ->where('status', false)
            ->where('deleted_at', null)
            // ->where('order_from', session('admin_id'))
            ->where('order_from', Auth::id())
            ->where('order_to_id', $product->product_by)
            ->first();

        // return $order;


        // $check_cart=$this->Distributor_model->check_cart($productId,$ProductData->product_by);

        if($order){
            $result = false;
            $quantity = request('quantity');
            $totalPrice = $order->price * $quantity;

            Order::where('id', $order->id)
                ->where('status', false)
                ->where('deleted_at', null)
                ->update([
                    'quantity' => DB::raw('quantity + ' . $quantity),
                    'total_price' => DB::raw('total_price + ' . $totalPrice),
                    'updated_at' => now(),
                ]);

            // $addedByQuantity = $this->getAddedByQuantity($mappedID);
            // $addedByQuantity = DB::table('products')
            //     ->select('product_mappings.added_by as product_by', 'product_mappings.d_price', 'product_mappings.s_price', 'users.role', 'product_mappings.quantity as highqty')
            //     ->join('product_mappings', 'product_mappings.product_id', '=', 'products.id')
            //     ->join('users', 'users.id', '=', 'product_mappings.added_by')
            //     ->where('product_mappings.deleted_at', null)
            //     ->where('products.deleted_at', null)
            //     ->where('users.deleted_at', null)
            //     ->where('product_mappings.id', $mappedID)
            //     ->first();

            // return $addedByQuantity;

            // $maxQuantity = $addedByQuantity->highqty;

            // $data = [
            //     'quantity' => $maxQuantity - $quantity,
            // ];

            // DB::table('product_mappings')
            //     ->where('id', $mappedID)
            //     ->update($data);

            // $result = true;

            // return $result;


        //Update Quantity 
        // $Order=$this->Distributor_model->update_myOrder($check_cart->id,$check_cart->price,$mappedID);
        }else{ 
        //New Entry
        // $Order=$this->Distributor_model->insertOrder($ProductData,$mappedID);
            $result = false;
            $quantity = request('quantity');
            $price = 0;
            $totalPrice = 0;

            if ($product->role == 1) {
                // Added by Factory
                $price = $product->d_price;
                $totalPrice = $quantity * $price;
            } elseif ($product->role == 3) {
                // Added by Distributor
                $price = $product->s_price;
                $totalPrice = $quantity * $price;
            }

            $order = new Order([
                'product_id' => request('productId'),
                'order_from' => auth()->id(),
                'order_to_id' => $product->product_by,
                'item' => '',
                'quantity' => $quantity,
                'price' => $price,
                'total_price' => $totalPrice,
                'added_by' => Auth::id(),
            ]);
            // return $order->save();

            // DB::beginTransaction();
            $order->save();

            try {
                // $order->save();
                // return "sdfasd";

                $addedByQuantity = ProductMapping::findOrFail($mappedID);
                // return $addedByQuantity;
                $maxQuantity = $addedByQuantity->quantity;

                ProductMapping::where('id', $mappedID)->update([
                    'quantity' => $maxQuantity - $quantity,
                ]);

                DB::commit();
                $result = true;
            } catch (\Exception $e) {
                DB::rollback();
            }

            // return "dsdasd";

        }
        if($order){
            // $this->session->set_flashdata('message', array('message' => 'Order Successfully Placed', 'class' => 'success'));   
            // if($loc=='1'){                    //if Order Places from Product Purchaze
            //     return redirect()->route('distributor.productPurchase')->with('success', 'Order Successfully Placed');
            // }else{                                           //Else
                return back()->with('success', 'Order Successfully Placed');
            // }
        }
        else{
            // $this->session->set_flashdata('message', array('message' => 'Something Went Wrong', 'class' => 'error'));
            // if($loc=='1'){                    //if Order Places from Product Purchaze
            //     return redirect()->route('distributor.productPurchase')->with('error', 'Something Went Wrong');
            // }else{                                        //Else
                return back()->with('error', 'Something Went Wrong');
            // }
        }
    }

    
    public function myOrderHistory()
    {
        $orders = Order::select('orders.*', 'users.name as Admin_name', 'products.name as product_name')
        ->join('products', 'products.id', '=', 'orders.product_id')
        ->join('users', 'users.id', '=', 'orders.order_to_id')
        ->where('orders.order_from', auth()->user()->id) 
        ->orderBy('orders.id', 'desc')
        ->get();

        // return $orders;
        return view ('company.order_history', compact('orders'));
    }

    public function cancelOrder($id){
        $id = decrypt($id);

        $order = Order::where('id', $id)->first();
        $order_to_id=$order->order_to_id;
        $product_id=$order->product_id;
        $order_id = Order::join('products','products.id', 'orders.product_id')
            ->join('product_mappings','products.id', 'product_mappings.product_id')
            ->where('product_mappings.product_id', $product_id)
            ->where('product_mappings.added_by',$order_to_id) 
            ->where('product_mappings.deleted_at', null)
            ->where('products.deleted_at', null)
            ->select('product_mappings.id as map_id','product_mappings.quantity')
            ->first();

        $enter_quantity=$order->quantity;
        $map_id=$order_id->map_id;
        $quantity=$order_id->quantity;

        ProductMapping::where('id',$map_id)->update([
            'quantity' => ($quantity + $enter_quantity),
        ]);
        Order::where('id',$id)->update([
            'deleted_at' => now(),
        ]);
        return back();

    }

    public function user_by_challan($id){
        $id = decrypt($id);
        // return $id;

        // $challans = Challan::join('users', 'challans.order_to_id', 'users.id')
        // ->join('challan_items', 'challans.id', 'challan_items.challan_id')
        // ->join('products', 'products.id', 'challan_items.product_id')
        // ->where('challans.user_id', auth()->user()->id)
        // ->orderBy('challans.id', 'desc')
        // ->groupBy('challans.id')
        // ->select('challans.*','users.name as OrderPersonName','challan_items.product_id','products.name','challan_items.quantity')
        // ->get();

        $challans = Challan::join('users', 'challans.order_to_id', 'users.id')
            ->join('challan_items', 'challans.id', 'challan_items.challan_id')
            ->join('products', 'products.id', 'challan_items.product_id')
            ->where('challans.user_id', auth()->user()->id)
            ->orderBy('challans.id', 'desc')
            ->groupBy('challans.id', 'challan_items.product_id', 'products.name', 'challan_items.quantity')
            ->select('challans.*', 'users.name as OrderPersonName', 'challan_items.product_id', 'products.name', 'challan_items.quantity')
            ->get();
        
        // return $challans;
        return view('company.view_user_by_challan', compact('challans'));
    }

    public function spareateChallanDetails($id){
        $challan_id = decrypt($id);

        $challans = ChallanItem::join('products', 'challan_items.product_id = products.id')
        ->join('product_mappings', 'challan_items.product_id  = product_mappings.product_id')
        ->join('users', 'users.id = product_mappings.added_by')
        ->join('challan', 'challan_items.challan_id = challan.id')
        ->where('challan_items.challan_id', $challan_id)
        ->group_by('challan_items.id')
        ->order_by('challan_items.id', 'asc')
        ->select('challan_items.*,products.name as Product_Name,product_mappings.s_price,product_mappings.d_price,users.role,challan.chalan_no')
        ->get();

        return $challans;
        
        return view('company.view_saperate_challan', compact('challans'));
    }


    public function aboutUs()
    {
        $about = About::first();
        if($about){
            return view ('company.about_us.edit', compact('about'));
        }else{
            return view ('company.about_us.create');
        }
    }

    public function contactUs()
    {
        $contact = Contact::first();
        if($contact){
            return view ('company.contact_us.edit', compact('contact'));
        }else{
            return view ('company.contact_us.create');
        }
    }

}
