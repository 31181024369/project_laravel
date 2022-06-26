@extends('layout.admin')
@section('content')

<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form action='{{route('post.update', $post->id)}}' method="POST" files = true enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="name" value="{{$post->title}}">
                    @error('title')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                

                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">value="{{!!$post->content!!}}"</textarea>
                    @error('content')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Danh mục</label> 
                    <select class="form-control" id="" name='cat'>
                      <option value=''>Chọn danh mục</option>
                        @foreach($cats as $cat)
                            <option value="{{$cat->id}}" @if($cat->id == old('cat'))
                                selected='selected'
                            @endif>{{str_repeat('-- ', $cat->level).' '.$cat->name}}</option>
                        @endforeach
                    </select>
                    @error('cat')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label font-weight-bold" for="upload-thumb">Ảnh</label>
                    <div id="uploadFile">
                        <img id="upload-image" src="{{asset($post->thumbnail)}}"><br>
                        <label class="btn btn-primary">
                            Chọn file<input type="file" class="uploadFile img" name="file" id="upload-thumb" onchange="show_upload_image()" value="{{ old('file') }}" style="width: 0px;height: 0px;overflow: hidden;">
                        </label>
                    </div>
                    @error('file')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="Chờ duyệt" @if($post->status=='Chờ duyệt')
                        checked
                    @endif>
                        <label class="form-check-label" for="status1">
                          Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="Công khai" @if($post->status=='Công khai')
                        checked
                    @endif>
                        <label class="form-check-label" for="status2">
                          Công khai
                        </label>
                    </div>
                    @error('status')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" name="btn-update" value="Cập nhật">Cập nhật</button>
            </form>
        </div>
    </div>
</div>

@endsection
