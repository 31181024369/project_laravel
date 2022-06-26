@extends('layout.shop')

@section('content')

<div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Điện thoại</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">Laptop</h3>
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiển thị 45 trên 50 sản phẩm</p>
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





            <div class="section" id="filter-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Bộ lọc</h3>
                </div>
                <div class="section-detail">
                    <form method="POST" action="">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Giá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-price" value-price="500000"></td>
                                    <td>Dưới 500.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" value-price="1000000"></td>
                                    <td>Dưới 1.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" value-price="5000000"></td>
                                    <td>Dưới 5.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" value-price="10000000"></td>
                                    <td>Dưới 10.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" value-price="20000000"></td>
                                    <td>Dưới 20.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value-price="50000000" name="r-price"></td>
                                    <td>Dưới 50.000.000đ</td>
                                    </tr>
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Hãng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-brand" value-brand="iphone"></td>
                                    <td>iPhone</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand" value-brand="oppo"></td>
                                    <td>Oppo</td>
                                </tr>
                                <tr>
                                    <td><input type="radio"  name="r-brand" value-brand="samsung"></td>
                                    <td>Samsung</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand" value-brand="xiaomi"></td>
                                    <td>Xiaomi</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand" value-brand="macbook"></td>
                                    <td>Macbook</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value-brand="asus" name="r-brand"></td>
                                    <td>Asus</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value-brand="acer" name="r-brand"></td>
                                    <td>Acer</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value-brand="msi" name="r-brand"></td>
                                    <td>Msi</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value-brand="huawei" name="r-brand"></td>
                                    <td>Huawei</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value-brand="ipad" name="r-brand"></td>
                                    <td>Ipad</td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Loại</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="type" value-type="1"></td>
                                    <td>Điện thoại</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value-type="2" name="type"></td>
                                    <td>Laptop</td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('input[type=radio]').click(function() {
                var value_price = $("input[name=r-price]:checked").attr("value-price");
                var value_brand = $("input[name=r-brand]:checked").attr("value-brand");
                var value_type = $("input[name=type]:checked").attr("value-type");
                var data = {
                    value_price: value_price,
                    value_brand: value_brand,
                    value_type: value_type
                };

                $.ajax({
                    type: "GET",
                    url: "{{url('product/search_fillter')}}",
                    data: data,
                    dataType: "html",
                    success: function(data) {
                        $(".main-content").html(data);
                    }
                });
            });
        });
    </script>


@endsection