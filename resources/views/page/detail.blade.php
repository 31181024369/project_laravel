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
            <div class="section" id="detail-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">{!!$Page->title!!}</h3>
                </div>
                <div class="section-detail">
                    <span class="create-date">28/11/2017</span>
                    <div class="detail">
                        {!!$Page->content!!}
                    </div>
                </div>
            </div>
            <div class="section" id="social-wp">
                <div class="section-detail">
                    <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                    <div class="g-plusone-wp">
                        <div class="g-plusone" data-size="medium"></div>
                    </div>
                    <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                </div>
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