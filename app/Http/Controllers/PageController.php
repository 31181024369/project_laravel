<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Product;

use App\Models\ProductCat;

class PageController extends Controller
{
    //
    function detail($id)
    {
    	$Page=Page::find($id);
    	$product_selling = Product::where('qty', '<=', 40)->limit(10)->get();
    	//return $Page;

    	$categories = ProductCat::whereNull('parent_id')
        ->with('childrenCategories')
        ->get();


    	return view('page.detail', compact('Page', 'product_selling', 'categories'));
    }
}
