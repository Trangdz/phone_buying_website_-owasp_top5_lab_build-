@extends('layouts.user.app_user')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Lấy bình luận theo người dùng</h4>
                </div>
                <div class="card-body">
                    <!-- User ID Form -->
                    <form method="GET" action="{{ route('user.user-comments',$tId) }}" class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="user_id" 
                                   value="{{ $userId ?? '' }}" placeholder="Nhập User ID...">
                            <button class="btn btn-primary" type="submit">Lấy bình luận</button>
                        </div>
                    </form>

                    <!-- Results -->
                    @if(isset($comments))
                        <h5>Bình luận của User ID: {{ $userId }}</h5>
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
                            {{-- <div class="alert alert-info">
                                Không tìm thấy bình luận nào cho User ID này.
                            </div> --}}
                        @endif
                    @endif
                    <div class="text-center mt-5">
                        @if(isset($tId))
                            <a href="{{ route('user.detail', $tId) }}" class="btn btn-outline-dark">
                                ← Quay lại trang chi tiết
                            </a>
                        @else
                            <a href="/" class="btn btn-outline-dark">
                                ← Quay lại trang chủ
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 