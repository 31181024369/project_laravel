@extends('layout.admin')

@section('content')


<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm trang
        </div>
        <div class="card-body">

            <form action='{{route('page.update', $page->id)}}' method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tiêu đề trang</label>
                    <input class="form-control" type="text" name="title" id="name" value="{{$page->title}}">
                    @error('title')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung trang</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{$page->content}}</textarea>
                    @error('content')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="Chờ duyệt" @if($page->status=='Chờ duyệt')
                            checked
                        @endif>
                        <label class="form-check-label" for="status1">
                          Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="Công khai" @if($page->status=='Công khai')
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