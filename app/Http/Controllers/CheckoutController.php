<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Checkout;
use App\Mail\CheckoutBuyNow;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\Product;
use App\Models\Order_product;
use Illuminate\Support\Facades\DB;
class CheckoutController extends Controller
{
    //
    function checkout()
    {
    	return view('checkout.checkout');
    }
    function store(Request $request)
    {
    	$request->validate(
            [
                'fullname' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'phone_number' => 'required',
                'pay_method' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'email' => ':attribute không đúng định dạng',
                'integer' => ':attribute phải là kiểu số'
            ],
            [
                'fullname' => "Họ và tên",
                'email' => "Email",
                'address' => "Địa chỉ nhận hàng",
                'phone_number' => "Số điện thoại",
                'pay_method' => "Phương thức thanh toán"
            ]
        );
        Order::create(
                [
                    'name' => $request->input('fullname'),
                    'address' => $request->input('address'),
                    'phone_number' => $request->input('phone_number'),
                    'email' => $request->input('email'),
                    'qty' => Cart::count(),
                    'price' => Cart::total(0,0,''),
                    'pay_method' => $request->input('pay_method'),
                    'notice' => $request->input('notice')
                ]
            );
        $order_id = Order::max('id');
        foreach (Cart::content() as $product) {
             DB::table('order_product')->insert([
                    'order_id' =>  $order_id,
                    'product_id' =>  $product->id,
                    'qty'=>$product->qty,
                ]);

        }

        $data = [
            'fullname' => $request->input('fullname'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email')
        ];
        Mail::to($request->input('email'))->send(new Checkout($data));
        return redirect('checkout')->with('status', 'Bạn đã đặt hàng thành công! Vui lòng kiểm tra mail để theo giỏi đơn hàng.');
        //return $request->input('email');
        //Mail::to($request->input('email'))->send(new Checkout);

        //return $request->input();
    }
    function buy_now($id){
        $product = Product::find($id);
        if($product->qty>0){
            return view('checkout.buy_now', compact('product'));
        }else{
           // return redirect('checkout')->with('warning', 'Xin lỗi! Sản phẩm này đã hết hàng hãy chọn mới hoặc mua những sản phẩm đã thêm vào giỏ hàng!');
           //return redirect('checkout'); 
           return redirect('checkout')->with('warning', 'Xin lỗi! Sản phẩm này đã hết hàng hãy chọn mới hoặc mua những sản phẩm đã thêm vào giỏ hàng!');
        }
    }
    function store_buyNow(Request $request, $id){
        $request->validate(
            [
                'fullname' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'phone_number' => 'required',
                'pay_method' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'email' => ':attribute không đúng định dạng',
                'integer' => ':attribute phải là kiểu số'
            ],
            [
                'fullname' => "Họ và tên",
                'email' => "Email",
                'address' => "Địa chỉ nhận hàng",
                'phone_number' => "Số điện thoại",
                'pay_method' => "Phương thức thanh toán"
            ]
        );

        $product = Product::find($id);
        Order::create(
            [
                'name' => $request->input('fullname'),
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'qty' => 1,
                'price' => $product->price,
                'pay_method' => $request->input('pay_method'),
                'notice' => $request->input('notice'),
            ]
        );
         $order_id = Order::max('id');
            DB::table('order_product')->insert([
                'order_id' =>  $order_id,
                'product_id' =>  $product->id,
                'qty'=>1,
            ]);

        $data = [
            'fullname' => $request->input('fullname'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'qty' => 1,
            'price' => $product->price,
            'pay_method' => $request->input('pay_method'),
            'notice' => $request->input('notice'),
            'product_name' => $product->name
        ];
        //return $request->input();

        Mail::to($request->input('email'))->send(new CheckoutBuyNow($data));
        Cart::destroy();
        return redirect('checkout')->with('status', 'Bạn đã đặt hàng thành công! Vui lòng kiểm tra mail để theo giỏi đơn hàng.');
    }
}
