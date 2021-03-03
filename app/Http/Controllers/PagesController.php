<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\PurchasedProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index(){
    	$page = "home";
    	return view('index', compact('page'));
    }

    public function invoices(){
    	$page = "invoices";
    	return view('invoices', compact('page'));
    }

    public function cart(){
    	$page = "sales";
    	return view('cart', compact('page'));
    }

    public function invoice_items($id){
    	$page = "items";
    	return view('items', compact('page', 'id'));
    }

    public function get_all_products(){
        $products = DB::table('products')->get();
        return response()->json([
            "status" => 1,
            "message" => "Success!",
            "items" => $products
        ], 200);
    }

    public function get_all_invoices(){
        $invoices = DB::table('invoices')->get();
        return response()->json([
            "status" => 1,
            "message" => "Success!",
            "items" => $invoices
        ], 200);
    }

    public function get_items($id){
        $items = DB::table('purchased_products')
                    ->where('invoice_id', $id)
                    ->join('products', 'purchased_products.product_id', '=', 'products.id')
                    ->get();

        return response()->json([
            "status" => 1,
            "message" => "Success!",
            "items" => $items
        ], 200);
    }

    public function create_product(){
    	$page = "create";
    	return view('create', compact('page'));
    }

    public function store_product(Request $request) {        
        // $this->validate(
        //     $request, [
        //         'product_code' => 'required|string|min:5|unique:products',
        //         'product_name' => 'required',
        //         'product_stock' => 'required',
        //         'product_price' => 'required'
        //     ]
        // );

        $product = new Product([
            'product_code' => $request->input('product.product_code'),
            'product_name' => $request->input('product.product_name'),
            'product_stock' => $request->input('product.product_stock'),
            'product_price' => $request->input('product.product_price')
        ]);
        $product->save();

        if($product->isDirty()){
            return response()->json([
                "status" => 0,
                "message" => "Item not posted!"
            ], 500);
        }

        return response()->json([
            "status" => 1,
            "message" => "Item posted successfully!"
        ], 200);
    }

    public function search(Request $request)
    {
        $products = DB::table('products')->where('product_name', 'LIKE', '%' . $request->input("search") . "%")->get();
        return response()->json([
            "status" => 1,
            "message" => "Success!",
            "items" => $products
        ], 200);
    }

    public function store_sale(Request $request)
    {
        // $this->validate(
        //     $request, [
        //         'total' => 'required|min:0',
        //         'products' => 'required'
        //     ]
        // );

        #Sale information
        $invoice = Invoice::create([
            'total' => $request->total,
        ]);
        $invoice->save();
        
        $products = $request->products;

        foreach ($products as $item) {        
            $product = PurchasedProducts::create([
                'product_id' => $item['id'],
                'invoice_id' => $invoice->id,
                'number_of_items' => $item['quantity'],
            ]);
            $product->save();

            if($item['product_stock'] > $item['quantity']){
                $item['product_stock'] = $item['product_stock'] - $item['quantity'];
                $product = Product::find($item['id']);
                $product->product_stock = $item['product_stock'];
                $product->save();
            } else {        
                return response()->json([
                    "status" => 0,
                    "message" => "Insufficient stock for " . $item['product_name'] . "!"
                ], 409);
            }
        }

        return response()->json([
            "status" => 1,
            "message" => "Sale posted successfully!"
        ], 200);   
    }

    public function pay_invoice(Request $request)
    {
        // $this->validate(
        //     $request, [
        //         'product_id' => 'required|min:1',
        //     ]
        // );

        #Sale information

        $invoice = Invoice::find($request->product_id);
        $invoice->paid = "true";
        $invoice->save();

        if ($invoice->isDirty()){
            return response()->json([
                "status" => 0,
                "message" => "Invoice status not updated!"
            ], 500); 
        }

        return response()->json([
            "status" => 1,
            "message" => "Paid!"
        ], 500);   
    }

}
