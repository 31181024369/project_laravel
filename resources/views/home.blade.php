@extends('layout.shop')

@section('content')
<div class="main-content fl-right">
            <div class="section" id="slider-wp">
                <div class="section-detail">
                    <div class="item">
                        <img src="public/images/slider-01.png" alt="">
                    </div>
                    <div class="item">
                        <img src="public/images/slider-02.png" alt="">
                    </div>
                    <div class="item">
                        <img src="public/images/slider-03.png" alt="">
                    </div>
                </div>
            </div>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-1.png">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-2.png">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-3.png">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-4.png">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-5.png">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach($product_standout as $standout)
                        <li>
                            <a href="{{url('san-pham/'.$standout->id.'-'.Str::slug($standout->name))}}" title="" class="thumb">
                                <img src="{{asset($standout->thumbnail)}}">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">{{$standout->name}}</a>
                            <div class="price">
                                <span class="new">{{ number_format($standout->price, 0,'','.')}}đ</span>
                                <span class="old">6.190.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{ url('them-gio-hang/'.$standout->id.'-'.Str::slug($standout->name)) }}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{ url('mua-ngay/'.$standout->id.'-'.Str::slug($standout->name)) }}" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>





            @foreach($product_cats as $cat)
                    @php
                        
                        $cats_child = data_tree($cats, $cat['id'], 0);
                        $cats_child[] = $cat;
                        $products_best_by_cat = array();
                        foreach ($products as $product) {
                            foreach ($cats_child as $cat) {
                                if($product['cat_id'] == $cat['id']){
                                    $products_best_by_cat[] = $product;
                                }
                            }
                        }
                        $products_best_by_cat = array_slice($products_best_by_cat, 0 ,8);
                    @endphp
                    @if($products_best_by_cat)
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">{{$cat->name}}</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($products_best_by_cat as $laptop)
                                <li>
                                    <a href="{{url('san-pham/'.$laptop->id.'-'.Str::slug($laptop->name))}}" title="" class="thumb">
                                        <img src="{{asset($laptop->thumbnail)}}">
                                    </a>
                                    <a href="{{url('san-pham/'.$laptop->id.'-'.Str::slug($laptop->name))}}" title="" class="product-name">{{$laptop->name}}</a>
                                    <div class="price">
                                        <span class="new">{{number_format($laptop->price, 0,'','.')}}đ</span>
                                        <span class="old">@if ($laptop->old_price>0)
                                            {{ number_format($laptop->old_price, 0,'', '.')}}đ
                                        @endif</span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ url('them-gio-hang/'.$laptop->id.'-'.Str::slug($laptop->name)) }}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ url('mua-ngay/'.$laptop->id.'-'.Str::slug($laptop->name)) }}" title="" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                 @endif
                @endforeach








            <!-- @foreach($product_cats as $cat)
                    @php
                        
                        $cats_child = data_tree($cats, $cat['id'], 0);
                        $cats_child[] = $cat;
                        $products_best_by_cat = array();
                        foreach ($products as $product) {
                            foreach ($cats_child as $cat) {
                                if($product['cat_id'] == $cat['id']){
                                    $products_best_by_cat[] = $product;
                                }
                            }
                        }
                        $products_best_by_cat = array_slice($products_best_by_cat, 0 ,8);
                    @endphp
                    @if($products_best_by_cat)
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title">{{$cat->name}}</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach($products_best_by_cat as $product)
                        <li>
                            <a href="{{url('san-pham/'.$product->id.'-'.Str::slug($product->name))}}" title="" class="thumb">
                                <img src="{{asset($product->thumbnail)}}">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">{{$product->name}}</a>
                            <div class="price">
                                <span class="new">{{ number_format($product->price, 0,'','.')}}đ</span>
                                <span class="old">8.990.000đđ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{ url('them-gio-hang/'.$product->id.'-'.Str::slug($product->name)) }}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{ url('mua-ngay/'.$product->id.'-'.Str::slug($product->name)) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>
             @endif
                @endforeach
 -->


           
        </div>
        <div class="sidebar fl-left">
            <!-- @include('inc.product_cat') -->


            <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail">
            <ul class="list-item">
            @foreach ($categories as $category)
                <li>
                    <a href="{{route('cat', Str::slug($category->name))}}" title="">{{ $category->name }}</a>
                    @if($category->childrenCategories->count()>0)
                        <ul class="sub-menu">
                        @foreach ($category->childrenCategories as $childCategory)
                            @include('layouts.child_category', ['child_category' => $childCategory])
                        @endforeach
                        </ul>                                  
                    @endif
                </li>
            @endforeach        
            </ul>
        </div>
    </div>




            @include('inc.product_selling')
           <!--  @include('inc.banner') -->
        </div>
    </div>
    @endsection