@extends('layout.shop')

@section('content')

<div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{url('/')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{url('san-pham')}}" title="">Sản Phẩm</a>
                    </li>
                    <li>
                        <a href="" title="">@if(request()->cat_id==1)
                            {{ 'Điện thoại' }}
                            @elseif(request()->cat_id==2)
                            {{ "Laptop" }}
                            @else(request()->cat_id==3)
                            {{ "Tablet" }}
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">@if(request()->cat_id==1)
                            {{ 'Điện thoại' }}
                            @elseif(request()->cat_id==2)
                            {{ "Laptop" }}
                            @else(request()->cat_id==3)
                            {{ "Tablet" }}
                            @endif</h3>
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiển thị {{ $count[0] }} trên {{ $count[1] }} sản phẩm</p>
                        <div class="form-filter">
                            <form  action="">
                                <select name="select">
                                    <option value="0">Sắp xếp</option>
                                    <option value="1">Từ A-Z</option>
                                    <option value="2">Từ Z-A</option>
                                    <option value="3">Giá cao xuống thấp</option>
                                    <option value="4">Giá thấp lên cao</option>
                                </select>
                                <button type="submit">Lọc</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                    	@foreach($Products as $Product)
                        <li>
                            <a href="{{url('san-pham/'.$Product->id.'-'.Str::slug($Product->name))}}" title="" class="thumb">
                                <img src="{{asset($Product->thumbnail)}}">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">{{$Product->name}}</a>
                            <div class="price">
                                <span class="new">{{ number_format($Product->price, 0,'','.')}}đ</span>
                                <span class="old">20.900.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{ url('them-gio-hang/'.$Product->id.'-'.Str::slug($Product->name)) }}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{ url('mua-ngay/'.$Product->id.'-'.Str::slug($Product->name)) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                {{$Products->links()}}
            </div>
        </div>
        <div class="sidebar fl-left">
            
             <!-- @include('inc.product_cat') -->
            @include('inc.product_selling')
            <!-- @include('inc.banner') -->
        </div>
    </div>

@endsection