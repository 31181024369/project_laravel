@extends('layout.admin')

@section('content')


<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form action='{{route('product.update', $product->id)}}' method="POST" files = true enctype="multipart/form-data" >
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{$product->name}}">
                            @error('name')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="code" class="font-weight-bold">Mã sản phẩm</label>
                            <input class="form-control" type="text" name="id" id="id" value="{{$product->id}}">
                            @error('id')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Giá</label>
                            <input class="form-control" type="text" name="price" id="price" value="{{$product->price}}">
                            @error('price')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="desc">Mô tả sản phẩm</label>
                            <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">{{$product->desc}}</textarea>
                            @error('desc')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Chi tiết sản phẩm</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{$product->content}}</textarea>
                    @error('content')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cat">Danh mục</label>
                    <select class="form-control" id="" name="cat_id">
                        <option value=''>Chọn danh mục</option>
                        @foreach($cats as $cat)
                            <option value="{{$cat->id}}" @if($product->cat_id==$cat->id)
                                selected='selected'
                            @endif
                            @if($cat->id == old('cat'))
                                selected='selected'
                            @endif>{{str_repeat('-- ', $cat->level).' '.$cat->name}}</option>
                        @endforeach
                    </select>
                    @error('cat')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label font-weight-bold" for="upload-thumb">Ảnh sản phẩm</label>
                    <div id="uploadFile">
                        <img id="upload-image" src="{{asset($product->thumbnail)}}"><br>
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
                    <input class="form-control" type="number" name="qty" id="qty" value="{{$product->qty}}" min='1'>
                    <div>
                        @error('qty')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
               
                <button type="submit" class="btn btn-primary" name="btn-update" value="Cập nhật">Cập nhật</button>
            </form>
        </div>
    </div>
</div>


@endsection