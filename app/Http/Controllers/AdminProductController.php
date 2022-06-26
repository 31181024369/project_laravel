<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductCat;


class AdminProductController extends Controller
{
    //
    function list(Request $request)
    {
    	//$products=Product::all();
        //$products=Product::paginate(5);
        $status = $request->input('status');
        $list_action = [
            'delete' => 'Xóa tạm thời'
        ];
        if($status == 'trash'){
            
            //$products = Product::onlyTrashed()->orderBy('id', 'desc')->paginate(10);
            $list_action = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $products = Product::onlyTrashed()->paginate(10);
        } else{
            $keyword ='';
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }
            $products = Product::where('name', 'LIKE', "%{$keyword}%")->orderBy('id', 'desc')->paginate(5);
        }


         foreach($products as $product){
            $cat = ProductCat::find($product->cat_id);
            $product['cat'] = $cat->name;
        }



        
        // $keyword = "";
        // if($request->input('keyword')){
            
        //     $keyword = $request->input('keyword');
        // }
        // $products = Product::where('name', 'LIKE', "%{$keyword}%")->orwhere('price', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_products_active = Product::count();
        $count_products_trash = Product::onlyTrashed()->count();
        $count = [$count_products_active, $count_products_trash];
        

    	return view('admin.product.list',compact('products','count','list_action'));
    }
    function add()
    {
        $cats= ProductCat::all();
        $cats= data_tree($cats);
    	return view('admin.product.add', compact('cats'));
    }
    function delete($id){
        if(Product::find($id)){
            $product = Product::find($id);
            $product->delete();
            return redirect('admin/product/list')->with('status', 'Xóa sản phẩm thành công!');
        }
        
        
    }
    function edit($id){
        $cats= ProductCat::all();
        $cats= data_tree($cats);
        $product = Product::find($id);
        return view('admin.product.edit', compact(['product', 'cats']));
    }
    function action(Request $request){
        //return "hoàng long";
        $list_check = $request->input('list_check');

        if($list_check){
            if (!empty($list_check)) {
            $action = $request->input('action');
                
            if($action == 'delete'){
                Product::destroy($list_check);
                return redirect('admin/product/list')->with('status', 'Chuyển sản phẩm vào thùng rác thành công!');
            }elseif($action == 'restore'){
                Product::withTrashed()
                ->whereIn('id', $list_check)
                ->restore();
                return redirect('admin/product/list')->with('status', 'Bạn đã khôi phục sản phẩm thành công!');
            }else{
                Product::withTrashed()
                ->whereIn('id', $list_check)
                ->forceDelete();
                return redirect('admin/product/list')->with('status', 'Bạn đã xóa vĩnh viễn sản phẩm thành công!');
            }
        }
        }else{
            return redirect('admin/product/list')->with('warning', 'Hãy chọn sản phẩm và hành động cần thực hiện!');
        }
    }
    function store(Request $request){
        $request->validate([
            'name' => 'required|unique:products|string|max:255',
            'id'=> 'required|unique:products',
            'price' => 'required|integer',
            'desc' => 'required|string',
            'content' => 'required|string',
            'qty'=> 'required|integer',
            'cat_id' => 'required',
            'file' => 'required|image',
        ],
        [
            'required'=>':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min',
            'max' => ':attribute có độ dài lớn nhất :max',
            'confirmed' => 'Xác nhận mật khẩu không thành công',
            'unique' => ':attribute đã tồn tại trong hệ thống!',
            'integer' => ':attribute chưa đúng định dạng số!',
            'image' => ':attribute chưa đúng định dạng!',
        ],
        [
            'name'=> 'Tiêu đề sản phẩm',
            'id'=> 'Mã sản phẩm',
            'price'=> 'Giá',
            'desc' => 'Mô tả sản phẩm',
            'content' => 'Nội dung',
            'qty'=> 'Số lượng',
            'cat_id' => 'Danh mục',
            'file' => 'Ảnh'
        ]
        );

        if($request->hasFile('file')){
            $file= $request->file;
            $filename= $file->getClientOriginalName();
            $thumbnail = "uploads/products/".$filename;
            $file->move('public/uploads/products/', $file->getClientOriginalName());
        }

        //$creator = Auth::user()->name;
        Product::create([
            'name' => $request->input('name'),
            'code'=> $request->input('code'),
            'price' => $request->input('price'),
            'desc' => $request->input('desc'),
            'content' => $request->input('content'),
            'qty' => $request->input('qty'),
            'cat_id' => $request->input('cat_id'),
            'thumbnail'=>$thumbnail,
        ]);

        return redirect('admin/product/list')->with('status', 'Đã thêm sản phẩm thành công!');
    }
    function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'id'=> 'required',
            'price' => 'required|integer',
            'desc' => 'required|string',
            'content' => 'required|string',
            'qty'=> 'required|integer',
            'cat_id' => 'required',
        ],
        [
            'required'=>':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min',
            'max' => ':attribute có độ dài lớn nhất :max',
            'confirmed' => 'Xác nhận mật khẩu không thành công',
            'unique' => ':attribute đã tồn tại trong hệ thống!',
            'integer' => ':attribute chưa đúng định dạng số!',
        ],
        [
            'name'=> 'Tiêu đề sản phẩm',
            'id'=> 'Mã sản phẩm',
            'price'=> 'Giá',
            'desc' => 'Mô tả sản phẩm',
            'content' => 'Nội dung',
            'qty'=> 'Số lượng',
            'cat_id' => 'Danh mục',
        ]
        );
        if($request->hasFile('file')){
            $request->validate([
                'file' => 'image',
            ],
            [
                'image'=> 'File không đúng định dạng ảnh',
            ],
            [
                'file' => 'Ảnh',
            ]);
            $file= $request->file;
            $filename= $file->getClientOriginalName();
            $thumbnail = "uploads/products/".$filename;
            $thumbnail_old = Product::find($id)->thumbnail;
            if(!empty($thumbnail_old)){
                unlink('public/'.$thumbnail_old);
            }
            $file->move('public/uploads/products/', $file->getClientOriginalName());
        } else{
            $thumbnail = Product::find($id)->thumbnail;
        }

        //$editor = Auth::user()->name;
        Product::where('id', $id)->update([
            'name' => $request->input('name'),
            'id'=> $request->input('id'),
            'price' => $request->input('price'),
            'desc' => $request->input('desc'),
            'content' => $request->input('content'),
            'qty' => $request->input('qty'),
            'cat_id' => $request->input('cat_id'),
            'thumbnail'=>$thumbnail,
        ]);

        return redirect('admin/product/list')->with('status', 'Đã cập nhật thành công!');
    }
    
    
}
