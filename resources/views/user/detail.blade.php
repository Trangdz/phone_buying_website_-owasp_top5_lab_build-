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
</div>
@endsection