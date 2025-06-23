@extends('layouts.user.app_user')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tìm kiếm bình luận</h4>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('user.search-comments') }}" class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" 
                                   value="{{ $search }}" placeholder="Nhập từ khóa tìm kiếm...">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </div>
                    </form>

                    <!-- Search Results -->
                    @if(isset($comments))
                        <h5>Kết quả tìm kiếm:</h5>
                        @if(count($comments) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Người bình luận</th>
                                            <th>Sản phẩm</th>
                                            <th>Nội dung</th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($comments as $comment)
                                        <tr>
                                            <td>{{ $comment->user_name }}</td>
                                            <td>{{ $comment->telephone_name }}</td>
                                            <td>{!! $comment->content !!}</td>
                                            <td>{{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Không tìm thấy bình luận nào phù hợp.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 