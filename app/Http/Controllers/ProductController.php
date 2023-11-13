<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCat;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    function detail($id)
    {
    	$Product=Product::find($id);
        //return $Product->cat_id;
        $product_selling = Product::where('qty', '<=', 3)->limit(10)->get();
        $Product_group=Product::where('cat_id',$Product->cat_id)->get();
        //return $Product_group;
    	//return $Product;

        $categories = ProductCat::whereNull('parent_id')
        ->with('childrenCategories')
        ->get();
    	return view('product.detail', compact('Product','product_selling', 'Product_group', 'categories'));
    }
    function list(Request $request, $cat_id)
    {
        $select=$request->input('select');
        if($select)
        {
            if($select==1)
            {
                $Products=Product::where('cat_id', $cat_id)->orderBy('name', 'desc')->paginate(4);
                
            }
            if($select==2)
            {
                $Products=Product::where('cat_id', $cat_id)->orderBy('name')->paginate(4);
            }
            if($select==3)
            {
                $Products=Product::where('cat_id', $cat_id)->orderBy('price', 'desc')->paginate(4);

            }
            if($select==4)
            {
                $Products=Product::where('cat_id', $cat_id)->orderBy('price')->paginate(4);

            }

        }
        else
        {
            $Products=Product::where('cat_id', $cat_id)->paginate(4);

        }
        $product_selling = Product::where('qty', '<=', 3)->limit(10)->get();
        $count_total = Product::where('cat_id', $cat_id)->count();
        $count_products = $Products->count();
        $count = [$count_products, $count_total];

         
        //$Products=Product::all();
        //return $Product;
        //return view('product.show', compact('Products'));

        return view('product.list', compact('Products', 'product_selling','count'));

    }
    function show_cat(Request $request, $cat_name)
    {

        $cats = ProductCat::all();
        foreach($cats as $cat){
            if(Str::slug($cat->name) ==  $cat_name){
                $cat_id = $cat->id;
            }
        }
        $product_cat = ProductCat::find($cat_id);
        //return $product_cat;

        







        $select=$request->input('select');
        if($select)
        {
            if($select==1)
            {
                $Products=Product::where('name', 'LIKE', "%{$cat_name}%")->orderBy('name', 'desc')->paginate(4);

                
                
            }
            if($select==2)
            {
                $Products=Product::where('name', 'LIKE', "%{$cat_name}%")->orderBy('name')->paginate(4);
                
            }
            if($select==3)
            {
                $Products=Product::where('name', 'LIKE', "%{$cat_name}%")->orderBy('price', 'desc')->paginate(4);
                

            }
            if($select==4)
            {
                $Products=Product::where('name', 'LIKE', "%{$cat_name}%")->orderBy('price')->paginate(4);
                

            }

        }
        else
        {
            $Products=Product::where('name', 'LIKE', "%{$cat_name}%")->paginate(4);
        }





        //return $Products;
        $product_selling = Product::where('qty', '<=', 3)->limit(10)->get();
        $count_total = Product::where('name', 'LIKE', "%{$cat_name}%")->count();
        $count_products = $Products->count();
        
        $count = [$count_products, $count_total];

        $categories = ProductCat::whereNull('parent_id')
        ->with('childrenCategories')
        ->get();
        //$Products=Product::all();
        //return $Product;
        //return view('product.show', compact('Products'));

        return view('product.show_cat', compact('Products', 'product_selling','count', 'categories'));

    }
    function show(Request $request)
    {
    	$select=$request->input('select');
    	if($select)
    	{
    		if($select==1)
    		{
    			$Products=Product::orderBy('name', 'desc')->paginate(8);
    			
    		}
    		if($select==2)
    		{
    			$Products=Product::orderBy('name')->paginate(8);
    		}
    		if($select==3)
    		{
    			$Products=Product::orderBy('price', 'desc')->paginate(8);

    		}
    		if($select==4)
    		{
    			$Products=Product::orderBy('price')->paginate(8);

    		}

    	}
    	else
    	{
    		$Products=Product::paginate(8);

    	}
    	//$Products=Product::all();
    	//return $Product;
         $categories = ProductCat::whereNull('parent_id')
        ->with('childrenCategories')
        ->get();

    	return view('product.show', compact('Products', 'categories'));
    	//return view('product.show');

    }
    function search(Request $request) {
        $keyword=Request()->keyword;
        $products=Product::where('name','LIKE',"%{$keyword}%")->get();
        $str_start="<ul class='list-cart-search'>";
        $array=array();
        foreach ($products as &$li){
            $li->price=number_format($li->price,0,',','.')."đ";
            $img=asset($li->thumbnail);
            $url=url('san-pham/'.$li->id.'-'.Str::slug($li->name));
            


            // $array[]="<li class='detailli'><a class='image_thumb' href='$url'><img class='image_search' src='$img'><a><a class='name_product' href=detailproduct/".$li->id.">".$li->name."</a><p class='margin-left'>Giá : $li->price</p></li>";

            $array[]="<li class='detailli'>
            <a class='image_thumb' href='$url'>
            <img class='image_search' src='$img'><a><a class='name_product' href='$url'>".$li->name."</a>
            <p class='margin-left'>Giá : $li->price</p>
            </li>";
        }
        $chuyen=implode('',$array);
        $search=$str_start.$chuyen."</ul>";
        echo $search;
    }


    function search_fillter(Request $request)
    {
        $output = "";
        $value_price = $request->get('value_price');
        $value_brand = $request->get('value_brand');
        $value_type = $request->get('value_type');

        if(!empty($value_price))
        {
            if(!empty($value_brand)&& !empty($value_type))
            {
                $result =Product::where('price', '<', $value_price)
                ->where('name', 'LIKE', "%{$value_brand}%")
                ->where('cat_id', $value_type)->get();
            }
            elseif(!empty($value_brand)&& empty($value_type))
            {
                $result =Product::where('price', '<', $value_price)
                ->where('name', 'LIKE', "%{$value_brand}%")->get();
            }
            elseif(empty($value_brand)&& !empty($value_type))
            {
                $result =Product::where('price', '<', $value_price)
                ->where('cat_id', $value_type)->get();
            }
            else
            {
                $result =Product::where('price', '<', $value_price)
                ->orderBy('price', 'desc')->get();;
            }

        }
        else
        {
            if(!empty($value_brand) && !empty($value_type)){
                    $result = Product::where('name', 'LIKE', "%{$value_brand}%")
                    ->where('cat_id', $value_type)
                    ->get();
                }elseif(empty($value_brand) && !empty($value_type)){
                    $result = Product::where('cat_id', $value_type)
                    ->get();
                }elseif(!empty($value_brand) && empty($value_type)){
                    $result = Product::where('name', 'LIKE', "%{$value_brand}%")
                    ->get();
                }
        }
        $count=count($result);
        if($count==0)
        {
            return "Không có kết quả tìm kiếm nào cho danh mục trên.";
        }

        if(!empty($result)){
                $output .= "<h1>Tìm thấy <b>{$count}</b> kết quả !</h1><br>";
                $output .= "<div class='section' id='list-product-wp'>";
                $output .= "<div class='section-detail'>";
                $output .= "<ul class='list-item clearfix'>";
                foreach ($result as &$product){
                    $product_price = number_format($product->price, 0, '', '.').'đ';
                    //$url=url('san-pham/'.$product->id.'-'.Str::slug($product->name));
                    $img=asset($product->thumbnail);
                    $url=url('san-pham/'.$product->id.'-'.Str::slug($product->name));
                    $output .= "<li>";
                    $output .= "<a href='$url' title='' class='thumb'>
                                    <img src='$img'>
                                </a>
                                <a href='' title='' class='product-name'> $product->name </a>
                                <div class='price'>
                                    <span class='new'>{$product_price}</span>
                                </div>
                                <div class='action clearfix'>
                                    <a href='' title='' class='add-cart fl-left'>Thêm giỏ hàng</a>
                                    <a href='' title='' class='buy-now fl-right'>Mua ngay</a>
                                </div>";
                    $output .= "</li>"; 
                }
                $output .= "</ul>";
                $output .= "</div>";
                $output .= "</div>";
                return $output;
        } 

    }
}
