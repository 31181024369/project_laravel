<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostCat;

class AdminPostController extends Controller
{
    //
    function list(Request $request)
    {
    	$status = $request->input('status');
    	$list_action = [
            'delete' => 'Xóa tạm thời'
        ];
    	if($status == 'trash'){

    		$list_action = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
       
            $posts = Post::onlyTrashed()->orderBy('id', 'desc')->paginate(10);
        } else{
            $keyword ='';
            if($request->input('keyword'))
            {
                 $keyword = $request->input('keyword');
            }
            $posts = Post::where('title', 'LIKE', "%{$keyword}%")->orderBy('id', 'desc')->paginate(5);
        }


    	foreach($posts as $post){
            $cat = PostCat::find($post->cat_id);
            $post['cat'] = $cat->name;
        }
        $count_posts_active = Post::count();
        $count_posts_trash = Post::onlyTrashed()->count();
        $count = [$count_posts_active, $count_posts_trash];
    	//return $posts;
    	return view('admin.post.list', compact('posts','count','list_action'));
    }
    function add()
    {
    	 $cats= PostCat::all();
        $cats = data_tree($cats);
    	return view('admin.post.add', compact('cats'));
    }
    function store(Request $request){
        $request->validate([
            'title' => 'required|unique:posts|string|max:255',
            'content' => 'required|string',
            
            'status'=> 'required',
            'cat' => 'required',
            'file' => 'required',
        ],
        [
            'required'=>':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min',
            'max' => ':attribute có độ dài lớn nhất :max',
            'confirmed' => 'Xác nhận mật khẩu không thành công',
            'unique' => ':attribute đã tồn tại trong hệ thống!'
        ],
        [
            'title'=> 'Tiêu đề bài viết',
            'content' => 'Nội dung',
           
            'status'=> 'Trạng thái',
            'cat' => 'Danh mục',
            'file' => 'Ảnh',
        ]
    );
        if($request->hasFile('file')){
            $file= $request->file;
            $filename= $file->getClientOriginalName();
            $thumbnail = "uploads/posts/".$filename;
            $file->move('public/uploads/posts/', $file->getClientOriginalName());
        }
        Post::create([
            'title' => $request->input('title'),

            'content' => $request->input('content'),
            'thumbnail'=> $thumbnail,
            'status' => $request->input('status'),
            'cat_id' => $request->input('cat'),
        ]);

        return redirect('admin/post/list')->with('status', 'Đã thêm bài viết thành công!');
    }
    function delete($id){
        if(Post::find($id)){
            $post = Post::find($id);
            $post->delete();
            return redirect('admin/post/list')->with('status', 'Xóa bài viết thành công!');
        }
        
    }
    function action(Request $request){
        //return "hoàng long";
        $list_check = $request->input('list_check');

        if($list_check){
            if (!empty($list_check)) {
            $action = $request->input('action');
                
            if($action == 'delete'){
                Post::destroy($list_check);
                return redirect('admin/post/list')->with('status', 'Chuyển bài viết vào thùng rác thành công!');
            }elseif($action == 'restore'){
                Post::withTrashed()
                ->whereIn('id', $list_check)
                ->restore();
                return redirect('admin/post/list')->with('status', 'Bạn đã khôi phục bài viết thành công!');
            }
            else{
                Post::withTrashed()
                ->whereIn('id', $list_check)
                ->forceDelete();
                return redirect('admin/post/list')->with('status', 'Bạn đã xóa vĩnh viễn bài viết thành công!');
            }
        }
        }else{
            return redirect('admin/post/list')->with('warning', 'Hãy chọn bài viết và hành động cần thực hiện!');
        }
    }
    function edit($id){
        $cats= PostCat::all();
        $cats= data_tree($cats);
        $post = Post::find($id);
        return view('admin.post.edit', compact(['post', 'cats']));
    }
    function update(Request $request, $id){
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            
            'status'=> 'required',
            'cat' => 'required',
        ],
        [
            'required'=>':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min',
            'max' => ':attribute có độ dài lớn nhất :max',
            'confirmed' => 'Xác nhận mật khẩu không thành công',
            'unique' => ':attribute đã tồn tại trong hệ thống!',
        ],
        [
            'title'=> 'Tiêu đề bài viết',
            'content' => 'Nội dung',
            
            'status'=> 'Trạng thái',
            'cat' => 'Danh mục',
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
            $thumbnail = "uploads/posts/".$filename;
            $file->move('public/uploads/posts/', $file->getClientOriginalName());
        } else{
            $thumbnail = Post::find($id)->thumbnail;
        }
        Post::where('id', $id)->update([
            'title' => $request->input('title'),
            
            'content' => $request->input('content'),
            'thumbnail'=> $thumbnail,
            'status' => $request->input('status'),
            'cat_id' => $request->input('cat'),
        ]);

        return redirect('admin/post/list')->with('status', 'Đã cập nhật thành công!');
    }

}
