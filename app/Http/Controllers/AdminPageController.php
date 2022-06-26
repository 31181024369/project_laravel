<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class AdminPageController extends Controller
{
    //
    function list(Request $request)
    {
    	$status = $request->input('status');
    	$list_act = [
            'delete'=>'Xóa tạm thời',
            'forceDelete'=>'Xóa vĩnh viễn',
        ];

    	if($status == 'trash'){
    		$list_act = [
                'restore'=>'Khôi phục',
                'forceDelete'=>'Xóa vĩnh viễn',
            ];
          
            $pages = Page::onlyTrashed()->paginate(10);
        } else{
            $keyword ='';
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }
            $pages = Page::where('title', 'LIKE', "%{$keyword}%")->paginate(10);
        }
        
        $count_pages_active = Page::count();
        $count_pages_trash = Page::onlyTrashed()->count();
        $count = [$count_pages_active, $count_pages_trash];
        return view('admin.page.list', compact('pages', 'count', 'list_act'));



    	
    }
    function add()
    {
    	return view('admin.page.add');
    }
    function store(Request $request){
        // return $request-> input('name');
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status'=> 'required',
        ],
        [
            'required'=>':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min',
            'max' => ':attribute có độ dài lớn nhất :max',
            'confirmed' => 'Xác nhận mật khẩu không thành công',
            'unique' => ':attribute đã tồn tại trong hệ thống!'
        ],
        [
            'title'=> 'Tiêu đề trang',
            'content' => 'Nội dung',
            'status'=> 'Trạng thái',
        ]
    );
        
        Page::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
        ]);

        return redirect('admin/page/list')->with('status', 'Đã thêm trang thành công!');
    }
    function delete($id){
        $page = Page::find($id);
        $page->delete();
        return redirect('admin/page/list')->with('status', 'Xóa trang thành công!');
    }
    function action(Request $request){
        $list_check = $request->input('list_check');
        if(!empty($list_check)){
            
            $act = $request->input('act');
            if(!empty($act)){
                if($act == 'delete'){
                    page::destroy($list_check);
                    return redirect('admin/page/list')->with('status', 'Xóa trang thành công!');
                }
                if($act == 'restore'){
                    page::onlyTrashed()->whereIn('id', $list_check)
                    ->restore();
                    return redirect('admin/page/list')->with('status', 'Khôi phục trang thành công!');
                }
                if($act == 'forceDelete'){
                    page::whereIn('id', $list_check)
                    ->forceDelete();
                    return redirect('admin/page/list')->with('status', 'Xóa vĩnh viễn trang thành công!');
                }
            } else{
                return redirect('admin/page/list')->with('status', 'Bạn chưa chọn tác vụ nào!');
            }
        } else{
            return redirect('admin/page/list')->with('status', 'Bạn chưa chọn trang nào!');
        }
    }
    function edit($id){
        $page = Page::find($id);
        // return $page;
        return view('admin.page.edit', compact(['page']));
    }

    function update(Request $request, $id){
        // return $request->input();
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status'=> 'required',
        ],
        [
            'required'=>':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min',
            'max' => ':attribute có độ dài lớn nhất :max',
            'confirmed' => 'Xác nhận mật khẩu không thành công',
            'unique' => ':attribute đã tồn tại trong hệ thống!'
        ],
        [
            'title'=> 'Tiêu đề trang',
            'content' => 'Nội dung',
            'status'=> 'Trạng thái',
        ]
    );
        Page::where('id', $id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
        ]);

        return redirect('admin/page/list')->with('status', 'Đã cập nhật thành công!');
    }
}
