<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductMapping;
use App\Models\Product;
use App\Models\Category;
use App\Models\Admin;
use App\Models\UnitMaster;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Challan;
use App\Models\About;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class ShopperController extends Controller
{
    public function productByDistributor()
    {
        $products = ProductMapping::join('products', 'products.id', '=', 'product_mappings.product_id')
            ->join('categories', 'products.categories', '=', 'categories.id')
            ->join('units', 'products.unit_name', '=', 'units.id')
            ->join('brands', 'products.brand', '=', 'brands.id')
            ->join('users', 'product_mappings.added_by', '=', 'users.id')
            ->select(
                'product_mappings.p_price',
                'product_mappings.g_price',
                'product_mappings.s_price',
                'product_mappings.product_id',
                'product_mappings.d_price',
                'product_mappings.id as mapped_id',
                'product_mappings.quantity as qty',
                'products.*',
                'categories.name as categories_name',
                'users.name as added_by_name',
                'users.address as admin_Add',
                'users.contact as admin_no',
                'users.id as dist_id',
                'brands.name as brandname',
                'units.unit_name as unitName'
            )
            // Add the WHERE condition
            ->whereIn('product_mappings.added_by', function ($query) {
                $query->select('added_by')
                    ->from('shoppers')
                    ->where('shopper_id', Auth::id())
                    ->whereNull('deleted_at')
                    ->orderBy('id', 'desc');
                    // ->limit(1); // Add a limit, assuming you only need one result
            })            
            ->whereNull('product_mappings.deleted_at')
            ->whereNull('products.deleted_at')
            ->get();

        return view ('shopper.all_product_purchase', compact('products'));
    }


    public function addOrder(Request $request )
    {
        // return $request->all();


        $loc=decrypt($request->Location);
        $productId=$request->productId;
        $mappedID=$request->mappedID;
        $product = Product::select('products.*', 'product_mappings.added_by as product_by', 'product_mappings.d_price', 'product_mappings.s_price', 'users.role')
            ->join('product_mappings', 'product_mappings.product_id', '=', 'products.id')
            ->join('users', 'users.id', '=', 'product_mappings.added_by')
            ->where('product_mappings.deleted_at', null)
            ->where('products.deleted_at', null)
            ->where('users.deleted_at', null)
            ->where('product_mappings.id', $mappedID)
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
            $addedByQuantity = DB::table('products')
                ->select('product_mappings.added_by as product_by', 'product_mappings.d_price', 'product_mappings.s_price', 'users.role', 'product_mappings.quantity as highqty')
                ->join('product_mappings', 'product_mappings.product_id', '=', 'products.id')
                ->join('users', 'users.id', '=', 'product_mappings.added_by')
                ->where('product_mappings.deleted_at', null)
                ->where('products.deleted_at', null)
                ->where('users.deleted_at', null)
                ->where('product_mappings.id', $mappedID)
                ->first();

            // return $addedByQuantity;

            $maxQuantity = $addedByQuantity->highqty;

            $data = [
                'quantity' => $maxQuantity - $quantity,
            ];

            DB::table('product_mappings')
                ->where('id', $mappedID)
                ->update($data);

            $result = true;

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
            // return $order;

            DB::beginTransaction();
            $order->save();

            try {
                // return "sdfasd";
                $order->save();

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
                return redirect()->route('shopper.productByDistributor')->with('success', 'Order Successfully Placed');
            // }
        }
        else{
            // $this->session->set_flashdata('message', array('message' => 'Something Went Wrong', 'class' => 'error'));
            // if($loc=='1'){                    //if Order Places from Product Purchaze
            //     return redirect()->route('distributor.productPurchase')->with('error', 'Something Went Wrong');
            // }else{                                        //Else
                return redirect()->route('shopper.productByDistributor')->with('error', 'Something Went Wrong');
            // }
        }
    }

    public function allProduct($brand = '', $category = '')
    {
        // return "test";
        $productInCart = Cart::where('shopper_id', Auth::id())->get();
        $products = ProductMapping::join('products', 'products.id', 'product_mappings.product_id')
            ->join('categories', 'products.categories', 'categories.id')
            ->join('users', 'product_mappings.added_by', 'users.id')
            ->join('brands', 'products.brand', 'brands.id')
            ->join('units', 'products.unit_name', 'units.id')
            ->select(
                'product_mappings.p_price',
                'product_mappings.g_price',
                'product_mappings.s_price',
                'product_mappings.product_id',
                'product_mappings.d_price',
                'product_mappings.id as mapped_id',
                'product_mappings.quantity as qty',
                'products.*',
                'categories.name as categories_name',
                'brands.name as brandname',
                'users.name as added_by_name',
                'users.id as dist_id',
                'users.role',
                'users.address as admin_Add',
                'users.contact as admin_no',
                'units.unit_name as unitName'
            )
            ->where('product_mappings.deleted_at', null)
            ->where('products.deleted_at', null);

        if (!empty($brand)) {
            $products->where('products.brand', $brand);
        }

        if (!empty($category)) {
            $products->where('products.categories', $category);
        }

        $products = $products->where('users.role', 3)
            ->where('users.deleted_at', null)
            ->where('brands.deleted_at', null)
            ->where('product_mappings.added_by', '!=', auth()->user()->id)
            ->whereNotIn('product_mappings.added_by', function ($query) {
                $query->select('added_by')
                    ->from('shoppers')
                    ->where('shopper_id', auth()->user()->id)
                    ->where('deleted_at', null);
            })
            ->orderBy('product_mappings.id', 'desc')
            ->get();

        $brands = Brand::get();
        $categories = Category::get();
        

        // return $products;

        return view ('shopper.all_product', compact(['productInCart', 'products', 'brands', 'categories']));
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
        return view ('shopper.order_history', compact('orders'));
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
        return view('shopper.view_user_by_challan', compact('challans'));
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
        
        return view('shopper.view_saperate_challan', compact('challans'));
    }

    public function dailyOrderChallan()
    {
        $orders = Order::select('orders.order_from', 'orders.id', 'users.name as OrderPersonName', 'users.area as area', 'users.address as address', 'orders.order_to_id', 'products.factoryImpoRs as currentFactoryRs', 'users.role as Role')
            ->join('users', 'orders.order_from', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.order_to_id', auth()->user()->id)
            ->orderBy('orders.id', 'desc')
            ->groupBy('orders.order_from', 'orders.id', 'users.name', 'users.area', 'users.address', 'orders.order_to_id', 'products.factoryImpoRs', 'users.role')
            ->get();
        
        return view('shopper.view_daily_order_challan', compact('orders'));
    }


    public function completedChallan()
    {
        $challansData = Challan::select('challans.*', 'users.name as OrderPersonName')
            ->join('users', 'challans.user_id', 'users.id')
            ->where('challans.order_to_Id', auth()->user()->id)
            ->orderBy('challans.id', 'desc')
            ->get();

        return view('shopper.view_completed_challan', compact('challansData'));
    }

    public function aboutUs()
    {
        $about = About::first();
        if($about){
            return view ('shopper.about_us.edit', compact('about'));
        }else{
            return view ('shopper.about_us.create');
        }
    }

    public function contactUs()
    {
        $contact = Contact::first();
        if($contact){
            return view ('shopper.contact_us.edit', compact('contact'));
        }else{
            return view ('shopper.contact_us.create');
        }
    }
}
