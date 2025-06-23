@extends('layouts.app_admin')

@section('content')
<div class="container">
    <h2>Product Edit</h2>

    
            <div>
                <strong>Ảnh đã tải lên:</strong><br>
                <img src="{{ asset('storage/' . $telephone->image) }}" alt="Uploaded Image" width="200">
            </div>
       
   

    <form action="{{route('admin.telephones.postEdit',['id'=>$telephone->id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Telephone name</label>
            <input type="text" name="name" class="form-control" required value="{{ $telephone->name }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" class="form-control" required value="{{ $telephone->price }}">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="number" class="form-label">Number</label>
            <input type="number" name="number" class="form-control" required value="{{ $telephone->number }}">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Select brand</label>
           <select name="brand"  class="form-select" required>
            <option value="0" disabled {{old('brand')==0? 'selected':''}}>Choose brand</option>
            <option value="1" {{$telephone->id ==1? 'selected':''}}>Samsung</option>
            <option value="2" {{$telephone->id ==2? 'selected':''}}>Apple</option>
            <option value="3" {{$telephone->id ==3? 'selected':''}}>Xiaomi</option>
            <option value="4" {{$telephone->id ==4? 'selected':''}}>Oppo</option>
           </select>
            @error('brand') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $telephone->brandId) }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $telephone->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Ảnh sản phẩm</label>
            <input type="file" name="image" class="form-control">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        
            @if (!empty($telephone->image))
                <small class="text-muted d-block mt-1">Ảnh hiện tại: {{ basename($telephone->image) }}</small>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Add product</button>
        <a href="{{route('admin.telephones.index')}}" type="button" class="btn btn-danger">Back</a>
    </form>
</div>
@endsection
