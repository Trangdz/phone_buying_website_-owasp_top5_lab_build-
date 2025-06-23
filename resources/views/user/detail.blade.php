@extends('layouts.user.app_user')

@section('content')

<div class="container my-5">
    <h2 class="fw-bold mb-4">Thông tin chi tiết sản phẩm</h2>
    <div class="row">
        <div class="col-md-5">
            <img src="{{ asset('storage/'.$telephone->image) }}" class="img-fluid rounded shadow" alt="{{ $telephone->name }}">
        </div>
        <div class="col-md-7">
            <form class="bg-light p-4 rounded shadow-sm">
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm:</label>
                    <input type="text" class="form-control" value="{{ $telephone->name }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá:</label>
                    <input type="text" class="form-control" value="{{ number_format($telephone->price, 0, ',', '.') }}₫" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả:</label>
                    <div class="p-3 border rounded bg-white">
                        {!! \Illuminate\Support\Facades\Blade::render($telephone->description ?? 'Sản phẩm này chưa có mô tả.') !!}
                    </div>
                </div>
                <a href="{{ route('user.add-to-cart',['id'=>$telephone->id]) }}" class="btn btn-primary">Add shopping cart</a>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Back to lists</a>
            </form>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Bình luận ({{ $telephone->comments->count() }})</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.search-comments') }}" class="btn btn-sm btn-outline-primary">Tìm kiếm bình luận</a>
                        <a href="{{ route('user.user-comments') }}" class="btn btn-sm btn-outline-secondary">Lấy comment theo user</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Add Comment Form -->
                    <form action="{{ route('user.store-comment', $telephone->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="content" class="form-label">Thêm bình luận:</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="3" 
                                      placeholder="Viết bình luận của bạn...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>

                    <!-- Comments List -->
                    @if($telephone->comments->count() > 0)
                        <div class="comments-list">
                            @foreach($telephone->comments as $comment)
                                <div class="comment-item border-bottom pb-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <strong class="me-2">{{ $comment->user->name }}</strong>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0">{!! $comment->content !!}</p>
                                        </div>
                                        @if(Auth::id() == $comment->user_id)
                                            <form action="{{ route('user.delete-comment', $comment->id) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                                    Xóa
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <p>Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection