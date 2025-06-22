@extends('layouts.app_admin')

@section('content')
<div class="container">
    <h2>Thêm sản phẩm mới</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @if (session('image'))
            <div>
                <strong>Ảnh đã tải lên:</strong><br>
                <img src="{{ asset('storage/' . session('image')) }}" alt="Uploaded Image" width="200">
            </div>
        @endif
    @endif

    <form action="{{route('admin.telephones.postAdd')}}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Telephone name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" class="form-control" required value="{{ old('price') }}">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="number" class="form-label">Number</label>
            <input type="number" name="number" class="form-control" required value="{{ old('number') }}">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Select brand</label>
           <select name="brand"  class="form-select" required>
            <option value="0" disabled {{old('brand')==0? 'selected':''}}>Choose brand</option>
            <option value="1" {{old('brand')==1? 'selected':''}}>Samsung</option>
            <option value="2" {{old('brand')==2? 'selected':''}}>Apple</option>
            <option value="3" {{old('brand')==3? 'selected':''}}>Xiaomi</option>
            <option value="4" {{old('brand')==4? 'selected':''}}>Oppo</option>
           </select>
            @error('brand') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5">{{old('description')}}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Ảnh sản phẩm</label>
            <input type="file" name="image" class="form-control">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add product</button>
        <a href="{{route('admin.telephones.index')}}" type="button" class="btn btn-danger">Back</a>
    </form>
</div>
@endsection
