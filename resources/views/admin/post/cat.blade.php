@extends('layout.admin')

@section('content')

<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục bài viết
                </div>
                @if(session('status'))
                    <div class="alert alert-success">
                        {{session('status')}}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{route('post.cat.add')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" id="" name="parent_id">
                                <option value="0" >Danh mục cha</option>
                                @foreach ($cats as $cat)
                                    <option value="{{$cat->id}}" @if($cat->id == old('parent_id'))
                                        selected='selected'
                                    @endif>{{str_repeat('-- ', $cat->level).' '.$cat->name}}</option>
                                @endforeach                     
                            </select>
                            @error('parent_id')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="Chờ duyệt" @if(old('status') =='Chờ duyệt') checked @endif>
                                <label class="form-check-label" for="status1">
                                Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status2" value="Công khai" @if(old('status')== 'Công khai') checked @endif>
                                <label class="form-check-label" for="status2">
                                Công khai
                                </label>
                            </div>
                            @error('status')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>




                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $ordinal=0;
                            @endphp
                            @foreach($cats as $k => $cat)
                             @php
                            $ordinal++;
                            @endphp
                            <tr>
                                <th scope="row">{{$ordinal}}</th>
                                 <td>{{str_repeat('-- ', $cat->level).' '.$cat->name}}</td>
                                <td>{{$cat->status}}</td>
                                <td>
                                    <a href="{{route('post.cat.edit', $cat->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                
                                   <a href="{{route('post.cat.delete', $cat->id)}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn chắc chắn muốn xóa bài viết này!')"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection