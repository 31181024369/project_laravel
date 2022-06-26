@extends('layout.admin')

@section('content')


<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm" name="keyword" value="{{ request()->input('keyword') }}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
        <div class="card-body">
            <div class="analytic">
                 <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">kích hoạt<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">vô hiệu quá<span class="text-muted">({{$count[1]}})</span></a>
            </div>
            <form action="{{route('product.action')}}" >
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="" name="action">
                    <option>Chọn</option>
                    @foreach ($list_action as $k => $value)
                                <option value="{{ $k }}">{{ $value }}</option>
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
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tình trạng</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                @if ($products->total() > 0)
                <tbody>

                    @php
                        $count = 0;
                    @endphp

                    @foreach($products as $product)
                            @php
                                $count++;
                            @endphp
                    <tr class="">
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{$product->id}}" @if(request()->input('list_check[{{$product->id}}]')) checked @endif>
                        </td>
                        <td>{{ $count }}</td>
                        <td><img width="100" src="{{ asset($product->thumbnail) }}" alt=""></td>
                        <td><a href="#">{{ Str::of($product->name)->limit(15) }}</a></td>
                        <td>{{ number_format($product->price, 0, '', '.') }}đ</td>
                        <td>{{ $product->cat }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ $product->status == 1 ? 'Chờ duyệt' : 'Đã đăng' }}</td>
                        <td><span
                                class="badge badge-success {{ $product->qty <= 0 ? 'badge-dark' : '' }}">{{ $product->qty > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                        </td>
                        <td>
                           <a href="{{route('product.edit', $product->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{route('delete_product', $product->id)}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn chắc chắn muốn xóa bài viết này!')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
                @else
                    <tr>
                        <td colspan="10" class="bg-white">Không tìm thấy kết quả phù hợp</td>
                    </tr>
                @endif
            </table>
            </form>
            {{ $products->links() }}
        </div>
    </div>
</div>

@endsection