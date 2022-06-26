<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCat;

class PostController extends Controller
{
    //
    function show()
    {
    	$Posts = Post::paginate(6);
        $product_selling = Product::where('qty', '<=', 40)->limit(10)->get();
    	//$Posts = Post::all();
    	//return $Posts;
         $categories = ProductCat::whereNull('parent_id')
        ->with('childrenCategories')
        ->get();
    	return view('post.show',compact('Posts', 'product_selling', 'categories'));
    }
    function detail($id)
    {
    	$Posts = Post::find($id);
        $product_selling = Product::where('qty', '<=', 40)->limit(10)->get();
    	//$Posts = Post::all();
    	//return $Posts;
        $categories = ProductCat::whereNull('parent_id')
        ->with('childrenCategories')
        ->get();
    	return view('post.detail',compact('Posts', 'product_selling', 'categories'));

    }
}
