@extends('layouts.user.app_user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>History</h4>
                </div>
                <div class="card-body">
                   
                    

                    @if($histories->count() > 0)
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
                                    @foreach($histories as $history)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-historys-center">
                                                @if($history->telephone->image)
                                                    <img src="{{ asset('storage/' . $history->telephone->image) }}" 
                                                         alt="{{ $history->telephone->name }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                                @endif
                                                <div>
                                                    <h6>{{ $history->telephone->name }}</h6>
                                                    <small class="text-muted">Brand: {{ $history->telephone->brandId }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($history->telephone->price) }} VNĐ</td>
                                        <td>{{ $history->quantity }}</td>
                                        <td>{{ number_format($history->telephone->price * $history->quantity) }} VNĐ</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                        <td><strong>{{ number_format($total) }} VNĐ</strong></td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>

                       
                        
                        <div class="d-flex justify-content-between align-historys-center mt-3">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                Shopping now
                            </a>
                            
                        </div>
                    @else
                        <div class="text-center py-4">
                            <h5>Empty shopping cart</h5>
                            <p>You don't buy anything in here.</p>
                            <a href="{{ route('user.index') }}" class="btn btn-primary">
                                Shopping now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
