@extends('layouts.user.app_user')

@section('content')

<!-- ===== Slider Section ===== -->
<div id="actSlider" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner rounded shadow">
        <div class="carousel-item active">
            <img src="{{ asset('storage/products/c.png') }}" class="d-block w-100" alt="Slide 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('storage/products/b.png') }}" class="d-block w-100" alt="Slide 2">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#actSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#actSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- ===== Products Section ===== -->
<div class="container">
    <h2 class="text-center fw-bold mb-4">Danh sách sản phẩm</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($telephones as $telephone)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 news-block">
                    <img src="{{ asset('storage/'.$telephone->image) }}" class="card-img-top" alt="{{ $telephone->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">{{ $telephone->name }}</h5>
                        <p class="card-text mb-2">Giá: <strong class="text-danger">{{ number_format($telephone->price, 0, ',', '.') }}₫</strong></p>
                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('user.detail', ['id' => $telephone->id]) }}" class="btn btn-outline-primary flex-fill">Xem chi tiết</a>
                            {{-- <form action="{{ route('user.add-to-cart', ['id' => $telephone->id]) }}" method="GET" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">+ Giỏ hàng</button>
                            </form> --}}
                            <a href="{{ route('user.add-to-cart', ['id' => $telephone->id]) }}" class="btn btn-success flex-fill">+ Giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ===== Custom Styles ===== -->
<style>
    .news-block img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }
</style>

<!-- ===== Slider Auto Script ===== -->
<script>
    const slider = document.querySelector('#actSlider');
    new bootstrap.Carousel(slider, {
        interval: 4000,
        ride: 'carousel'
    });
</script>

@endsection