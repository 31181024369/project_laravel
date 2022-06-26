<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Models\ProductCat;

class HomeController extends Controller
{
    //
    function home()
    {
    	//$Products=Product::all();
    	//return $Products;
        $product_standout = Product::orderBy('name', 'desc')->get();
        $product_selling = Product::where('qty', '<=', 40)->limit(10)->get();
    	$product_phone = Product::where('cat_id', 1)->get();
        $product_laptop = Product::where('cat_id', 2)->get();


        //$product_tablet = Product::where('cat_id', 3)->get();

         $product_cats = ProductCat::where('parent_id', '=', Null)->get();
        $cats = ProductCat::all();
        //$products = Product::orderBy('id', 'desc')->get();
        $products = Product::all();

        //return $product_cats;
        //return $products;



        $categories = ProductCat::whereNull('parent_id')
        ->with('childrenCategories')
        ->get();

    	return view('home', compact('product_phone', 'product_laptop', 'product_standout', 'product_selling', 'categories', 'product_cats', 'cats', 'products'));
    }
    function search_header(Request $request)
    {
        if($request->has('search')){
            $text = $request->search;
            $output = "";
            if($text){
                $result_product = Product::where('name', 'LIKE', "%{$text}%")->orwhere('price', 'LIKE', "%{$text}%")->get();
                $count_product = Product::where('name', 'LIKE', "%{$text}%")->orwhere('price', 'LIKE', "%{$text}%")->count();

                //return $result_product;
                //return $count_product;

                if($count_product > 0){
                    $output .= "<h1>Tìm thấy {$count_product} kết quả cho từ khóa <b>'{$text}'</b></h1><br>";
                    $output .= "<div class='section' id='list-product-wp'>";
                    $output .= "<div class='section-detail'>";
                        $output .= "<ul class='list-item clearfix'>";
                            foreach ($result_product as &$product){
                                
                                $item_product = number_format($product->price, 0, '', '.').'đ';
                                $img=asset($product->thumbnail);
                                 $url=url('san-pham/'.$product->id.'-'.Str::slug($product->name));
                                $output .= "<li>";
                                    $output .= "<a href='$url' title='' class='thumb'>
                                        <img src='$img'>
                                    </a>
                                    <a href='$url' title='' class='product-name'>$product->name</a>
                                    <div class='price'>
                                        <span class='new'>{$item_product}</span>
                                    </div>
                                    <div class='action clearfix'>
                                        <a href='' title='' class='add-cart fl-left'>Thêm giỏ hàng</a>
                                        <a href='' title='' class='buy-now fl-right'>Mua ngay</a>
                                    </div>";
                                    $output .= "
                                </li>";
                            }
                            $output .= "</ul>";
                        $output .= "</div>";
                    $output .= "</div>";
                    return $output;
                }else{
                    if($count_product <= 0){
                        $result_post = Post::where('title', 'LIKE', "%{$text}%")->get();
                        $count = Post::where('title', 'LIKE', "%{$text}%")->count();
                        if($result_post){
                            $output .= "<h1>Tìm thấy {$count} kết quả cho từ khóa <b>'{$text}'</b></h1><br>";
                            $output .= "<div class='section' id='list-blog-wp'>";
                            $output .= "<div class='section-detail'>";
                            $output .= "<ul class='list-item clearfix'>";
                                    foreach ($result_post as &$post){
                                        if($post->cat_id == 1) $post->name = 'Điện thoại'; else $post->name = 'Máy tính - Laptop';
                                        
                                        $img=asset($post->thumbnail);
                                         $url=url('bai-viet/'.$post->id.'-'.Str::slug($post->title));

                                        $output .= "<li class='clearfix'>";
                                            $output .= "<a href='$url' title='' class='thumb fl-left'>
                                                <img src='$img' alt=''>
                                            </a>
                                            <div class='info fl-right'>
                                                <a href='$url' title='' class='title'>{$post->title}</a>
                                                <span class='create-date'></span>
                                                    <p class='desc'>{$post->name}</p>
                                            </div>";
                                            $output .= "
                                        </li>";
                                    }
                                    $output .= "</ul>";
                                $output .= "</div>";
                            $output .= "</div>";
                        }
                        return $output;
                    }
                }
            }else{
                return "<b>Hãy nhập từ khóa bạn muốn tìm kiếm cho sản phẩm và bài viết. Hoặc nhấn <a href='http://localhost/unitop.vn/unimart_pro/unimart/'>vào đây</a> để tiếp tục mua hàng.</b>";
        }
    }
    }
}
