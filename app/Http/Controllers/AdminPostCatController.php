<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostCat;

class AdminPostCatController extends Controller
{
    //
    function list()
    {
    	$cats= PostCat::all();
    	$cats = data_tree($cats);
    	//return $cats;

    	return view('admin.post.cat', compact('cats'));
    }
    function add_cat(Request $request){
        $request->validate([
            'name' => 'required|unique:post_cats|string|max:255',
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
        PostCat::create([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'status' => $request->input('status'),
        ]);
        return redirect('admin/post/cat/list')->with('status', 'Đã thêm danh mục bài viết thành công!');
    }
    function delete_cat($id){
        $post_cat = PostCat::find($id);
        $post_cat->delete();
        return redirect('admin/post/cat/list')->with('status', 'Xóa danh mục bài viết thành công!');
    }
    function edit_cat($id){
        $cats= PostCat::all();
        $cats= data_tree($cats);
        $post_cat = PostCat::find($id);
        
        return view('admin.post.edit_cat', compact(['post_cat', 'cats']));
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
        PostCat::where('id', $id)->update([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'status' => $request->input('status'),
        ]);
        return redirect('admin/post/cat/list')->with('status', 'Đã cập nhật danh mục bài viết thành công!');
    }
}
