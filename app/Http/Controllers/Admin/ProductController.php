<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Eloquent
        $products = Product::paginate(config('myconfig.item_per_page'));

        //QueryBuilder
        //SELECT product.*, product_category.name
        // FROM product INNER JOIN product_category
        //  ON product_category.id = product.product_category_id;

        // $products = DB::table('product')
        // ->join('product_category', 'product_category.id', '=','product.product_category_id')
        // ->select('product.*', 'product_category.name as product_category_name')
        // ->paginate(config('myconfig.item_per_page'));

        return view('admin.product.list', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //SQL Raw
        // $productCategories = DB::select('select * from product_category where status = 1');

        //Query Builder
        // $productCategories = DB::table('product_category')->where('status', 1)->get();

        //Eloquent
        // $productCategories = ProductCategory::all();
        $productCategories = ProductCategory::where('status', 1)->get();

        return view('admin.product.create')->with('productCategories', $productCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate
        $request->validate([
            'name' => 'required',
            'product_category_id' => 'required'
        ]);

        //SQL Raw
        // $check = DB::insert("INSERT INTO product ('name') VALUES (?) ", [$request->name]);
        //Query Builder
        // $check = DB::table('product')->insert(['name' => $request->name]);

        $fileName = null;
        if ($request->hasFile('image_url')) {
            $originName = $request->file('image_url')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image_url')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('image_url')->move(public_path('images'), $fileName);
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'information' => $request->information,
            'qty' => $request->qty,
            'shipping' => $request->shipping,
            'weight' => $request->weight,
            'status' => $request->status,
            'product_category_id' => $request->product_category_id,
            'image_url' => $fileName
        ]);

        $message = $product ? 'create success' : 'create failed';

        return redirect()->route('admin.product.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
