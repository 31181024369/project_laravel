<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProductCat;


class AdminProductCatController extends Controller
{
    //
    function list()
    {
    	$cats= ProductCat::all();
    	$cats = data_tree($cats);
       
        //return $cats;

    	return view('admin.product.cat',compact('cats'));
    }
    function add_cat(Request $request){
        $request->validate([
            'name' => 'required|unique:product_cats|string|max:255',
            'status'=> 'required',
            'parent_id' => 'required',
        ],
        [
            'required'=>':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min',
            'max' => ':attribute có độ dài lớn nhất :max',
            'confirmed' => 'Xác nhận mật khẩu không thành công',
            'unique' => ':attribute đã tồn tại trong hệ thống!'
        ],
        [
            'name'=> 'Tiêu đề danh mục',
            'status'=> 'Trạng thái',
            'parent_id' => 'Danh mục cha',
        ]
    );
        ProductCat::create([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'status' => $request->input('status'),
        ]);
        return redirect('admin/product/cat/list')->with('status', 'Đã thêm danh mục sản phẩm thành công!');
    }
    function delete_cat($id){
        $product_cat = ProductCat::find($id);
        $product_cat->delete();
        return redirect('admin/product/cat/list')->with('status', 'Xóa danh mục sản phẩm thành công!');
    }
    function edit_cat($id){
        $cats= ProductCat::all();
        $cats= data_tree($cats);
        $product_cat = ProductCat::find($id);
        
        return view('admin.product.edit_cat', compact(['product_cat', 'cats']));
    }
    function update_cat(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'status'=> 'required',
            'parent_id' => 'required',
        ],
        [
            'required'=>':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min',
            'max' => ':attribute có độ dài lớn nhất :max',
            'confirmed' => 'Xác nhận mật khẩu không thành công',
            'unique' => ':attribute đã tồn tại trong hệ thống!'
        ],
        [
            'name'=> 'Tiêu đề danh mục',
            'status'=> 'Trạng thái',
            'parent_id' => 'Danh mục cha',
        ]
    );
        ProductCat::where('id', $id)->update([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'status' => $request->input('status'),
        ]);
        return redirect('admin/product/cat/list')->with('status', 'Đã cập nhật danh mục sản phẩm thành công!');
    }
}
