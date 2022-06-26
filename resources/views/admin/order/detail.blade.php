@extends('layout.admin')
@section('content')

<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <div id="content-detail" class="detail-exhibition">
            <div class="section" id="info">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <ul class="list-item">
                    <li>
                        <h4 class="title">Mã đơn hàng</h4>
                        <span class="detail text-success">{{$order->id}}</span>
                    </li>
                    <li>
                        <h4 class="title">Địa chỉ nhận hàng</h4>
                        <span class="detail text-success">{{$order->address}}/{{$order->phone_number}}</span>
                    </li>
                    <li>
                        <h4 class="title">Thông tin vận chuyển</h4>
                        <span class="detail text-success">
                        @if($order->pay_method == 1 )
                            Thanh toán tại nhà
                        @else
                            Thanh toán tại cửa hàng
                        @endif
                        </span>
                    </li>
                    <form method="POST" action="" class="form-action form-inline">
                        @csrf
                        <li>
                            <h3 class="title">Tình trạng đơn hàng</h3>
                            <select name="status" class="form-control">
                                <option  value='Đang xử lý' @if($order->status == 1)
                                    selected='selected'
                                @endif>Đang xử lý</option>
                                <option value='Đã giao' @if($order->status==2)
                                    selected='selected'
                                @endif>Đã giao</option>
                                <option  value='Đã hủy' @if($order->status==3)
                                    selected='selected'
                                @endif>Đã hủy</option>                            
                            </select>
                            <input type="submit" name="sm_status" value="Cập nhật đơn hàng" class="btn btn-primary">
                        </li>
                    </form>
                    @if(session('status'))
                    <div class="alert alert-success">
                        {{session('status')}}
                    </div>
                @endif
                </ul>
            </div>
            <div class="section">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm đơn hàng</h3>
                </div>
                <div class="table-responsive">
                    <table class="table info-exhibition">
                        <thead>
                            <tr>
                                <th class="thead-text">STT</th>
                                <th class="thead-text">Ảnh sản phẩm</th>
                                <th class="thead-text">Tên sản phẩm</th>
                                <th class="thead-text">Đơn giá</th>
                                <th class="thead-text">Số lượng</th>
                                <th class="thead-text">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $ordinal=0;
                            @endphp
                            @foreach($products as $product)
                            @php
                                $ordinal++;
                            @endphp
                                <tr>
                                    <td class="thead-text">{{$ordinal}}</td>
                                    <td class="thead-text">
                                        <div class="thumb">
                                            <img src="{{asset($product->thumbnail)}}" alt="">
                                        </div>
                                    </td>
                                    <td class="thead-text">{{$product->name}}</td>
                                    <td class="thead-text">{{number_format($product->price)}} VNĐ</td>
                                    <td class="thead-text">{{$qty[$ordinal-1]}}</td>
                                    <td class="thead-text">{{number_format($product->price * $qty[$ordinal-1])}} VNĐ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="section">
                <h3 class="section-title">Giá trị đơn hàng</h3>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <span class="total-fee">Tổng số lượng</span>
                            <span class="total">Tổng đơn hàng</span>
                        </li>
                        <li>
                            <span class="total-fee">{{$order->qty}} sản phẩm</span>
                            <span class="total">{{number_format($order->price)}} VNĐ</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
