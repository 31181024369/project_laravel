@extends('layout.admin')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[1]}}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[0]}}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[2]}}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>

        

        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">{{number_format($proceeds)}}</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
       
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        @if(count($orders)>0)
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mã</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá trị</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Chi tiết</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                   @php
                                $ordinal = 0;
                            @endphp
                            @foreach($orders as $order)
                                @php
                                    $ordinal++;
                                @endphp
                                <tr>
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
                        <td>
                            <a href="{{ route('order.edit', $order->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('delete_order', $order->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" onclick="return confirm('Bạn có muốn xóa đơn hàng này?')" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                                </tr>
                            @endforeach
                   
                </tbody>
            </table>
            @else
                        <tr>
                            <td><p class="text-danger p-3">Không tồn tại đơn hàng nào!</p></td>
                        </tr>
                </div>
            @endif
            <nav aria-label="post navigation example">
                {{$orders->links()}}
            </nav>
        </div>
    </div>

</div>
@endsection