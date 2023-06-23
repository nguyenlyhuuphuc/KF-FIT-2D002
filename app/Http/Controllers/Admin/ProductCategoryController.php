<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function store(Request $request){
        //Validate data from client
        $request->validate([
            'name' => 'required|min:1|max:255|string',
            // 'slug' => 'required|min:1|max:255|string',
            'status' => 'required|boolean'
        ],[
            'name.required' => 'Ten buoc phai nhap !'
        ]);

        //SQL RAW
        // $check = DB::insert('insert into product_category(name,slug,status) values (?, ?, ?)',
        //  [$request->name, $request->slug, $request->status]);

        //Query Builder
        $check = DB::table('product_category')->insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ]);

        //
        // $lastId = DB::table('product_category')->insertGetId([
        //     'name' => $request->name,
        //     'slug' => $request->slug,
        //     'status' => $request->status
        // ]);

        $msg = $check ? 'Create Product Category Success' : 'Create Product Category Failed';

        return redirect()->route('admin.product_category.list')->with('message', $msg);
    }

    public function getSlug(Request $request){
        $slug = Str::slug($request->name);
        return response()->json(['slug' => $slug]);
    }
}
