@extends('layout.admin')

@section('content')


<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form action='{{route('product.store')}}' method="POST" files = true enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                             <label for="code" class="font-weight-bold">Mã sản phẩm</label>
                            <input class="form-control" type="text" name="id" id="code" value="{{ old('id') }}">
                            @error('code')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Giá </label>
                            <input class="form-control" type="number" name="price" id="price" value="{{ old('price') }}">
                            @error('price')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="desc" class="font-weight-bold">Mô tả sản phẩm</label>
                            <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">{{ old('desc') }}</textarea>
                            @error('desc')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label for="content" class="font-weight-bold">Chi tiết sản phẩm</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{ old('content') }}</textarea>
                    @error('content')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="cat_id" class="font-weight-bold">Danh mục</label>
                    <select class="form-control" id="" name="cat_id">
                        <option value=''>Chọn danh mục</option>
                        @foreach($cats as $cat)
                            <option value="{{$cat->id}}" @if($cat->id == old('cat'))
                                selected='selected'
                            @endif>{{str_repeat('-- ', $cat->level).' '.$cat->name}}</option>
                        @endforeach
                    </select>
                    @error('cat_id')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                 <div class="form-group">
                    <label class="form-label font-weight-bold" for="upload-thumb">Ảnh sản phẩm</label>
                    <div id="uploadFile">
                        <img id="upload-image" src="{{asset('uploads/img-thumb.png')}}"><br>
                        <label class="btn btn-primary">
                            Chọn file<input type="file" class="uploadFile img" name="file" id="upload-thumb" onchange="show_upload_image()" value="{{ old('file') }}" style="width: 0px;height: 0px;overflow: hidden;">
                        </label>
                    </div>
                    @error('file')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="" class="font-weight-bold">Số lượng</label>
                    <input class="form-control" type="number" name="qty" id="qty" value="{{ old('qty') }}" min='1'>
                    <div>
                        @error('qty')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>



                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>

@endsection