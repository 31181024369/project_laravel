@extends('layout.shop')

@section('content')
<div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Blog</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach($Posts as $Post)
                        <li class="clearfix">
                            <a href="{{url('bai-viet/'.$Post->id.'-'.Str::slug($Post->title))}}" title="" class="thumb fl-left">
                                <img src="{{asset($Post->thumbnail)}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{url('bai-viet/'.$Post->id.'-'.Str::slug($Post->title))}}" title="" class="title">{{$Post->title}}</a>
                                <span class="create-date">28/11/2017</span>
                                <p>{{$Post->cat_id==1?"Điện thoại":" Laptop"}}</p>
                            </div>
                        </li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>
            <div class="section float-right" id="paging-wp">
                    {{$Posts->links()}}
            </div>
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
            <!-- @include('inc.banner') -->
        </div>
    </div>
@endsection