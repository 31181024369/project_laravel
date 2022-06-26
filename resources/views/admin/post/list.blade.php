@extends('layout.admin')

@section('content')



<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách bài viết</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" class="form-control form-search" placeholder="Tìm kiếm" name="keyword" value="{{request()->input('keyword')}}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif
        <div class="card-body">
           <div class="analytic">
                    <a href="{{request()->fullUrlwithQuery(['status'=>'active'])}}" class="text-primary">Kích hoạt<span class="text-muted">({{$count[0]}})</span></a>
                    <a href="{{request()->fullUrlwithQuery(['status'=>'trash'])}}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{$count[1]}})</span></a>
                </div>
            @if(count($posts)>0)
            <form action="{{route('post.action')}}" method="POST">
                    @csrf
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="" name="action">
                    <option value="">Chọn</option>
                    @foreach($list_action as $k => $v)
                    <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">
                            <input name="checkall" type="checkbox">
                        </th>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Ngày sửa</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                     </tr>
                </thead>
                <tbody>
                     @php
                        $ordinal = 0;
                    @endphp
                    @foreach($posts as $post)
                    @php
                        $ordinal++;
                    @endphp
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{$post->id}}">
                        </td>
                         <td scope="row">{{$ordinal}}</td>
                        <td><img src="{{asset($post->thumbnail)}}" style='width: 100px; heigt: auto;' alt=""></td>
                        <td><a href="#">{{ Str::of($post->title)->limit(25) }}</a></td>
                        <td>{{$post->cat}}</td>
                        <td>{{$post->created_at}}</td>
                        <td><a href="" class="text-success">{{$post->status}}</a></td>
                        <td><a href="{{route('post.edit', $post->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{route('delete_post', $post->id)}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn chắc chắn muốn xóa bài viết này!')"><i class="fa fa-trash"></i></a>
                        </td>

                    </tr>
                     @endforeach
                
                </tbody>
            </table>
            </form>
            @else
                <tr>
                    <td><p class="text-danger p-3">Không tồn tại bài viết nào!</p></td>
                </tr>
            @endif
            <nav aria-label="Page navigation example">
                {{$posts->links()}}
            </nav>
        </div>
    </div>
</div>

@endsection