<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function index(){
        $cart = session()->get('cart') ?? [];
        return view('client.pages.cart', compact('cart'));
    }
    public function addProductToCart($productId){
        $product = Product::find($productId);
        if($product){
            $cart = session()->get('cart') ?? [];

            $imageLink = (is_null($product->image_url) || !file_exists("images/" . $product->image_url))
            ? 'default-product-image.png' : $product->image_url;

            $cart[$product->id]  = [
                'name' => $product->name,
                'price' => $product->price,
                'image_url' => asset('images/'.$imageLink),
                'qty' => ($cart[$productId]['qty'] ?? 0) + 1
            ];
            //Add cart into session
            session()->put('cart', $cart);

            return response()->json(['message' => 'Add product success!']);
        }else{
            return response()->json(['message' => 'Add product failed!'], Response::HTTP_NOT_FOUND);
        }
    }
}
