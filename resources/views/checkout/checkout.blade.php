@extends('layout.shop')

@section('content')

<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        @if (session('warning'))
                <div class="alert bg-warning">{{ session('warning') }}</div>
            @endif
            @if (session('status'))
                <div class="alert bg-success">{{ session('status') }}</div>
            @endif
                <form method="post" action="{{ url('checkout/store') }}" name="form-checkout">
                    @csrf
                <div class="section" id="customer-info-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin khách hàng</h1>
                    </div>
                <div class="section-detail">
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname">Họ tên</label>
                            <input type="text" name="fullname" id="fullname">
                            @error('fullname')
                                <small class="alet text-danger font-italic">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email">
                            @error('email')
                                <small class="alet text-danger font-italic">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="address">Địa chỉ</label>
                            <input type="text" name="address" id="address">
                            @error('address')
                                <small class="alet text-danger font-italic">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" name="phone_number" id="phone_number">
                            @error('phone_number')
                                <small class="alet text-danger font-italic">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="notes">Ghi chú</label>
                            <textarea name="note"></textarea>
                        </div>
                    </div>
            </div>
        </div>
        <div class="section" id="order-review-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin đơn hàng</h1>
            </div>
            <div class="section-detail">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <td>Sản phẩm</td>
                            <td>Tổng</td>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach(Cart::content() as $cart)
                        <tr class="cart-item">
                            <td class="product-name">{{Str::of($cart->name)->limit(50) }}<strong class="product-quantity">x {{$cart->qty}}</strong></td>
                            <td class="product-total">{{ number_format($cart->subtotal, 0, '', '.') }}đ</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                        <tr class="order-total">
                            <td>Tổng đơn hàng:</td>
                            <td><strong class="total-price" >{{ Cart::subtotal(0, '', '.') }}đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div id="payment-checkout-wp">
                    <ul id="payment_methods">
                        <li>
                            <input type="radio" id="direct-payment" name="pay_method" value="2">
                            <label for="direct-payment">Thanh toán tại cửa hàng</label>
                        </li>
                        <li>
                            <input type="radio" id="payment-home" name="pay_method" value="1">
                            <label for="payment-home">Thanh toán tại nhà</label>
                        </li>
                        @error('pay_method')
                            <small class="alet text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </ul>
                </div>
                <div class="place-order-wp clearfix">
                    <input type="submit" id="order-now" value="Đặt hàng" name="btn_checkout">
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection