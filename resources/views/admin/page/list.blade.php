@extends('layout.admin')

@section('content')

<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách thành viên</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm" name="keyword" value="{{request()->input('keyword')}}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif
        @if(count($pages)>0)
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlwithQuery(['status'=>'active'])}}" class="text-primary">Kích hoạt<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlwithQuery(['status'=>'trash'])}}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{$count[1]}})</span></a>
            </div>
            <form action="{{route('page.action')}}" method="POST">
                    @csrf
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="" name="act">
                    <option>Chọn</option>
                     @foreach($list_act as $k => $v)
                                <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkall">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                	@php
                            $ordinal = 0;
                    @endphp
                    @foreach($pages as $page)
                        @php
                            $ordinal++;
                        @endphp
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{$page->id}}">
                                    </td>
                            <td scope="row">{{$ordinal}}</td>
                            <td><a href="">{{$page->title}}</a></td>
                            <td>{{$page->created_at}}</td>
                            <td><a href="" class="text-success">{{$page->status}}</a></td>
                        <td>
                            <a href="{{route('page.edit', $page->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                           <a href="{{route('delete_page', $page->id)}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn chắc chắn muốn xóa trang này!')"><i class="fa fa-trash"></i></a>
                        </td>
        
                    @endforeach
                    </tr>
                </tbody>
            </table>
            </form>
            <nav aria-label="Page navigation example">
                {{$pages->links()}}
            </nav>
        </div>
        @else
            <tr>
                <td><p class="text-danger p-3">Không tồn tại trang nào!</p></td>
            </tr>
        @endif
    </div>
</div>


@endsection