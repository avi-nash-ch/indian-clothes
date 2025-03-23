<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductMapping;
use App\Models\Order;
use App\Models\About;
use App\Models\Contact;
use App\Models\Challan;
use App\Models\Brand;
use App\Models\Category;
use App\Models\GstText;
use App\Models\Unit;
use App\Models\User;
use App\Models\Distributor;
use App\Models\Shopper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class FactoryController extends Controller
{
    
    public function allProductPurchase($brand = '', $category = '')
    {
        $products = ProductMapping::join('products', 'product_mappings.product_id', 'products.id')
            ->join('users', 'product_mappings.added_by', 'users.id')
            ->join('categories', 'products.categories', 'categories.id')
            ->join('units', 'products.unit_name', 'units.id')
            ->join('brands', 'products.brand', 'brands.id')
            ->select(
                'products.*',
                'product_mappings.s_price',
                'product_mappings.d_price',
                'product_mappings.id as mapped_id',
                'product_mappings.quantity',
                'brands.name as brandname',
                'categories.name as categories_name',
                'users.name as added_by_Name',
                'users.role',
                'users.address as admin_Add',
                'users.contact as admin_no',
                'units.unit_name as unitName'
            )
            ->where('categories.deleted_at', null);

        if (!empty($brand)) {
            $products->where('products.brand', $brand);
        }

        if (!empty($category)) {
            $products->where('products.categories', $category);
        }

        $products = $products->where('brands.deleted_at', null)
            ->where('products.deleted_at', null)
            ->where('users.deleted_at', null)
            ->where('product_mappings.added_by', '!=', auth()->user()->id)
            ->where('users.role', '!=', 1)
            ->where('product_mappings.deleted_at', null)
            ->orderByDesc('id')
            ->get();

            // return $products;

        return view ('factory.all_product_purchase', compact('products'));
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
                return redirect()->route('factory.allProductPurchase')->with('success', 'Order Successfully Placed');
            // }
        }
        else{
            // $this->session->set_flashdata('message', array('message' => 'Something Went Wrong', 'class' => 'error'));
            // if($loc=='1'){                    //if Order Places from Product Purchaze
            //     return redirect()->route('distributor.productPurchase')->with('error', 'Something Went Wrong');
            // }else{                                        //Else
                return redirect()->route('factory.allProductPurchase')->with('error', 'Something Went Wrong');
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
        return view ('factory.order_history', compact('orders'));
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
        return view('factory.view_user_by_challan', compact('challans'));
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
        
        return view('factory.view_saperate_challan', compact('challans'));
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
        
        return view('factory.view_daily_order_challan', compact('orders'));
    }


    public function completedChallan()
    {
        $challansData = Challan::select('challans.*', 'users.name as OrderPersonName')
            ->join('users', 'challans.user_id', 'users.id')
            ->where('challans.order_to_Id', auth()->user()->id)
            ->orderBy('challans.id', 'desc')
            ->get();

        return view('factory.view_completed_challan', compact('challansData'));
    }

    public function manageProduct()
    {
        $products = ProductMapping::join('products', 'products.id', 'product_mappings.product_id')->join('brands', 'brands.id', 'products.brand')->join('categories', 'categories.id', 'products.categories')->join('units', 'units.id', 'products.unit_name')->join('gst_texts', 'gst_texts.id', 'products.gst_text')->join('users', 'users.id', 'products.added_by')->select('products.*', 'brands.name as brandName', 'categories.name as categoryName', 'units.unit_name as unitName', 'gst_texts.gst_text as GST', 'users.name as addedByName', 'product_mappings.d_price', 'product_mappings.p_price', 'product_mappings.g_price', 'product_mappings.s_price', 'product_mappings.quantity')->where('product_mappings.added_by', Auth::id())->get();
        return view ('factory.product.manageProduct', compact('products'));
    }

    public function addProduct(Request $request )
    {
        $request->validate([
            'd_price' => 'required',
            'p_price' => 'required',
            'g_price' => 'required',
            's_price' => 'required',
            'quantity' => 'required',
        ]);

        $productMapping = new ProductMapping();

        $productMapping->product_id = $request->product_id;
        $productMapping->d_price = $request->d_price;
        $productMapping->p_price = $request->p_price;
        $productMapping->g_price = $request->g_price;
        $productMapping->s_price = $request->s_price;
        $productMapping->quantity = $request->quantity;

        $productMapping->added_by = Auth::id();

        if($productMapping->save()){
            return redirect()->route('distributor.manageProduct')->with('success', 'Product has been added successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        };
    }

    public function productIndex(Request $request)
    {
        $brands = Brand::get();
        $categories = Category::get();
        if ($request->brand  != '') {
            $products = Product::join('brands', 'brands.id', 'products.brand')->join('categories', 'categories.id', 'products.categories')
                ->join('units', 'units.id', 'products.unit_name')->join('gst_texts', 'gst_texts.id', 'products.gst_text')
                ->select('products.*', 'brands.name as brandName', 'categories.name as categoryName', 'units.unit_name as unitName', 'gst_texts.gst_text as GST')
                ->where('brand', $request->brand)
                ->get();
                // $brands = Brand::get();
                // $categories = Category::get();
        }elseif ($request->categories  != '') {
            $products = Product::join('brands', 'brands.id', 'products.brand')->join('categories', 'categories.id', 'products.categories')->join('units', 'units.id', 'products.unit_name')->join('gst_texts', 'gst_texts.id', 'products.gst_text')->select('products.*', 'brands.name as brandName', 'categories.name as categoryName', 'units.unit_name as unitName', 'gst_texts.gst_text as GST')->where('product.categories', $request->categories)->get();
            // $brands = Brand::get();
            // $categories = Category::get();
        }elseif ($request->categories  != '' && $request->brand  != '') {
            $products = Product::join('brands', 'brands.id', 'products.brand')->join('categories', 'categories.id', 'products.categories')->join('units', 'units.id', 'products.unit_name')->join('gst_texts', 'gst_texts.id', 'products.gst_text')->select('products.*', 'brands.name as brandName', 'categories.name as categoryName', 'units.unit_name as unitName', 'gst_texts.gst_text as GST')->where('product.categories', $request->categories)->where('brand', $request->brand)->get();
            // $brands = Brand::get();
            // $categories = Category::get();
        }else{
            // $brands = Brand::get();
            // $categories = Category::get();
            $products = Product::join('brands', 'brands.id', 'products.brand')->join('categories', 'categories.id', 'products.categories')->join('units', 'units.id', 'products.unit_name')->join('gst_texts', 'gst_texts.id', 'products.gst_text')->join('users', 'users.id', 'products.added_by')->select('products.*', 'brands.name as brandName', 'categories.name as categoryName', 'units.unit_name as unitName', 'gst_texts.gst_text as GST', 'users.name as addedByName')->get();
        }

        return view ('factory.product.index', compact(['products', 'brands', 'categories']));
    }

    public function productCreate(){
        $brands = Brand::get();
        $categories = Category::get();
        $gstTexts = GstText::get();
        $units = Unit::get();
        return view ('factory.product.create', compact(['brands', 'categories', 'gstTexts', 'units']));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'productCode' => 'required',
            'unit_name' => 'required',
            'brand' => 'required',
            'gst_text' => 'required',
            'categories' => 'required',
            'image' => 'required|mimes:gif,jpg,png,jpeg',
        ]);

        $product = new Product();

        $product->name = $request->name;
        $product->productCode = $request->productCode;
        $product->unit_name = $request->unit_name;
        $product->brand = $request->brand;
        $product->gst_text = $request->gst_text;
        $product->categories = $request->categories;
        // $product->factoryImpoRs = $request->factoryImpoRs;
        // $product->DistWholesalerRs = $request->DistWholesalerRs;
        // $product->shoperPrice = $request->shoperPrice;
        // $product->companyPrice = $request->companyPrice;
        // $product->quantity = $request->quantity;
        // $product->status = $request->status;
        if ($image = $request->file('image')) {

            $destinationPath = 'admin/assets/product/';
            $productImage = $image->getClientOriginalName();
            $image->move($destinationPath, $productImage);
            $product->image = "$productImage";
        }

        $product->added_by = Auth::id();

        if($product->save()){
            return redirect()->route('factory.product')->with('success', 'Product has been added successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        };
    }

    public function productEdit($id)
    {
        $id = decrypt($id);
        $productMapping = ProductMapping::join('products', 'products.id', 'product_mappings.product_id')->where('product_id', $id)->select('product_mappings.*', 'products.name')->first();
        return view ('factory.product.edit', compact('productMapping'));
    }

    public function productUpdate(Request $request, $id)
    {
        $request->validate([
            'd_price' => 'required',
            'p_price' => 'required',
            'g_price' => 'required',
            's_price' => 'required',
            'quantity' => 'required',
        ]);
        
        $productMapping = ProductMapping::where('id',$id)->first();

        // $productMapping->product_id = $request->product_id;
        $productMapping->d_price = $request->d_price;
        $productMapping->p_price = $request->p_price;
        $productMapping->g_price = $request->g_price;
        $productMapping->s_price = $request->s_price;
        $productMapping->quantity = $request->quantity;

        $productMapping->added_by = Auth::id();


        if($productMapping->save()){
            return redirect()->route('factory.manageProduct')->with('success', 'Product has been updated successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        };
    }

    public function productDelete($id)
    {
        $id = decrypt($id);
        $productMapping = ProductMapping::where('product_id', $id)->first();
        if($productMapping->delete()){
            return back()->with('success', 'Product has been deleted successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        };
    }

    public function salesmanIndex()
    {
        $salesmans = User::where('role', 2)->where('added_by', Auth::id())->get();
        return view ('factory.salesman.index', compact('salesmans'));
    }

    public function salesmanCreate(){
        return view ('factory.salesman.create');
    }

    public function salesmanStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'contact' => 'required|unique:users,contact',
            'area' => 'required|string',
            'email' => 'required||email|unique:users,email',
            'password' => 'required|string',
        ], 
        [
            'contact.unique' => 'Contact Already Exist'
        ]);

        $salesman = new User();

        $salesman->name = $request->name;
        $salesman->role = 2;
        $salesman->contact = $request->contact;
        $salesman->email = $request->email;
        $salesman->password = bcrypt($request->password);
        $salesman->simple_password = $request->password;
        $salesman->area = $request->area;
        $salesman->added_by = Auth::id();

        if($salesman->save()){
            return redirect()->route('factory.salesman')->with('success', $this->currentPageTitles.' has been added successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        };
    }

    public function salesmanEdit($id)
    {
        $id = decrypt($id);
        $salesman = User::where('id', $id)->first();
        return view ('factory.salesman.edit', compact('salesman'));
    }

    public function salesmanUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'contact' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'area' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'required|string',
        ],
        [
            'contact.unique' => 'Contact Already Exist'
        ]);
        
        $salesman = User::where('id',$id)->first();
        $salesman->name = $request->name;
        $salesman->role = 2;
        $salesman->contact = $request->contact;
        $salesman->email = $request->email;
        $salesman->password = bcrypt($request->password);
        $salesman->simple_password = $request->password;
        $salesman->area = $request->area;
        $salesman->added_by = Auth::id();

        if($salesman->save()){
            return redirect()->route('factory.salesman')->with('success', $this->currentPageTitles.' has been updated successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        };
    }

    public function salesmanDelete($id)
    {
        $id = decrypt($id);
        $salesman = User::where('id', $id)->first();
        if($salesman->delete()){
            return back()->with('success', $this->currentPageTitles.' has been deleted successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        };
    }

    public function manageDistributor()
    {
        $distributors = Distributor::join('users', 'distributors.distributor_id', 'users.id')
        ->select('distributors.*', 'users.*')
        ->where('distributors.deleted_at', null)
        ->where('distributors.role', 3)
        ->where('users.deleted_at', null)
        ->where('distributors.status', 0)
        ->where('distributors.added_by', auth()->user()->id)
        ->orderByDesc('distributors.id')
        ->get();

        return view ('factory.distributor.index', compact('distributors'));
    }

    public function distributorDelete($id)
    {
        $id = decrypt($id);
        $distributor = Distributor::where('id', $id)->first();
        if($distributor->delete()){
            return back()->with('success', $this->currentPageTitles.' has been deleted successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        };
    }

    public function aboutUs()
    {
        $about = About::first();
        if($about){
            return view ('factory.about_us.edit', compact('about'));
        }else{
            return view ('factory.about_us.create');
        }
    }

    public function contactUs()
    {
        $contact = Contact::first();
        if($contact){
            return view ('factory.contact_us.edit', compact('contact'));
        }else{
            return view ('factory.contact_us.create');
        }
    }

}
