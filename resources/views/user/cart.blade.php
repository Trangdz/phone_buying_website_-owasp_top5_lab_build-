@extends('layouts.user.app_user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Giỏ hàng</h4>
                </div>
                <div class="card-body">
                    {{-- Thông báo --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Hiển thị số dư --}}
                    <div class="mb-3">
                        <h5>Số dư tài khoản: 
                            <span class="text-success">
                                {{ number_format($userBalance) }} VNĐ
                            </span>
                        </h5>
                    </div>

                    @if($cartItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Products</th>
                                        <th>Price</th>
                                        <th>Number</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->telephone->image)
                                                    <img src="{{ asset('storage/' . $item->telephone->image) }}" 
                                                         alt="{{ $item->telephone->name }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                                @endif
                                                <div>
                                                    <h6>{{ $item->telephone->name }}</h6>
                                                    <small class="text-muted">Brand: {{ $item->telephone->brandId }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->telephone->price) }} VNĐ</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->telephone->price * $item->quantity) }} VNĐ</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                        <td><strong>{{ number_format($total) }} VNĐ</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Cảnh báo nếu số dư không đủ --}}
                        @if($userBalance < $total)
                            <div class="alert alert-warning mt-3">
                                <strong>Chú ý:</strong> Số dư tài khoản của bạn không đủ để thanh toán đơn hàng.
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                Tiếp tục mua hàng
                            </a>
                            <form action="{{ route('user.checkout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary" {{ $userBalance < $total ? 'disabled' : '' }}>
                                    Thanh toán
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <h5>Giỏ hàng trống</h5>
                            <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                            <a href="{{ route('user.index') }}" class="btn btn-primary">
                                Mua sắm ngay
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
