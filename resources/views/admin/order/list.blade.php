@extends('layout.admin')

@section('content')

<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
        @endif
        @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="" name="keyword" class="form-control form-search" placeholder="Tìm kiếm" value="{{ request()->input('keyword') }}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ request()->fullUrlWithQuery(['status' => 'processing']) }}" class="text-primary">Đang xử
                        lí<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}" class="text-primary">Đã
                        giao<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'home']) }}" class="text-primary">Thanh toán tại
                        nhà<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'store']) }}" class="text-primary">Thanh toán tại
                        cửa hàng<span class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng
                        rác<span class="text-muted">({{ $count[4] }})</span></a>
            </div>
            <form action="{{ url('admin/order/action') }}">
                    @csrf
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="" name="action">
                    <option>Chọn</option>
                    @foreach ($list_action as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
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
                        <th scope="col">Mã</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá trị</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thanh toán</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Chi tiết</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if($orders->total()>0) 
                    @php
                        $ordinal = 0;
                    @endphp
                    @foreach($orders as $order)
                    @php
                        $ordinal++;
                    @endphp
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $order->id }}">
                        </td>
                        <td>{{$ordinal}}</td>
                        <td>{{ $order->id}}</td>
                        <td>
                            {{ $order->name}} <br>
                            {{ $order->phone_number}}
                        </td>
                        <td>{!!$order->address!!}</td>
                        <td>{{$order->qty}}</td>
                        <td>{{number_format($order->price)}}₫</td>

                        <td><span class="badge
                                            @if ($order->status == 1) {{ 'badge-warning' }}
                                            @elseif ($order->status==2)
                                                {{ 'badge-success' }}
                                            @else
                                                {{ 'badge-dark' }} @endif">

                                                @if ($order->status == 1)
                                                    {{ 'Đang xử lí' }}
                                                @elseif ($order->status==2)
                                                    {{ 'Đã giao' }}
                                                @else
                                                    {{ 'Đã hủy' }}
                                                @endif
                            </span>
                        </td>
                        <td>{{ $order->pay_method == 1 ? 'Tại nhà' : 'Tại cửa hàng' }}</td>

                        <td>{{$order->created_at}}</td>
                        <td><a href="{{route('order.detail', $order->id)}}" title="" class="tbody-text">Chi tiết</a></td>
                            <td>
                        <td>
                            <a href="{{ route('order.edit', $order->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('delete_order', $order->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" onclick="return confirm('Bạn có muốn xóa đơn hàng này?')" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else

                    <tr>
                        <td colspan="11"><p>không tìm thấy bản ghi</p></td>
                    </tr>
                    @endif

                </tbody>
            </table>
            </form>
             {{$orders->links()}}
        </div>
    </div>
</div>

@endsection